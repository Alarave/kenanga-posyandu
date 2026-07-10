<?php

namespace App\Imports;

use App\Contracts\FileParserInterface;
use App\Imports\Parsers\CsvFileParser;
use App\Imports\Parsers\XlsFileParser;
use App\Imports\Parsers\XlsxFileParser;
use App\Imports\Processors\PatientRowProcessor;
use App\Imports\Resolvers\HeaderResolver;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

/**
 * PatientImport — Orchestrator (Clean Code, OOP, SRP).
 *
 * Coordinates the full import pipeline without containing any
 * parsing, resolution, or processing logic itself:
 *
 *   UploadedFile
 *     → FileParser (CSV / XLSX)
 *     → HeaderResolver (detect + normalize + alias)
 *     → PatientRowProcessor (validate → Patient → MedicalRecord)
 *
 * Supported formats: CSV (comma / semicolon / tab), XLSX.
 *
 * @see CsvFileParser
 * @see XlsxFileParser
 * @see HeaderResolver
 * @see PatientRowProcessor
 */
class PatientImport
{
    // ── Counters & diagnostics (read after import()) ──────────────────

    /** Number of new patients created. */
    public int $imported = 0;

    /** Number of rows that were skipped due to validation errors or being empty. */
    public int $skipped = 0;

    /** Number of MedicalRecord entries created. */
    public int $recordsImported = 0;

    /** Accumulated warning/error messages. */
    public array $errors = [];

    /** Raw header row found in the file (for debugging). */
    public array $debugHeaders = [];

    // ── Dependencies ──────────────────────────────────────────────────

    private HeaderResolver $headerResolver;

    private PatientRowProcessor $rowProcessor;

    public function __construct(int $posyanduId, int $userId)
    {
        $this->headerResolver = new HeaderResolver;
        $this->rowProcessor = new PatientRowProcessor($posyanduId, $userId);
    }

    // ── Public API ────────────────────────────────────────────────────

    /**
     * Run the full import pipeline for the given uploaded file.
     *
     * @throws \InvalidArgumentException for unsupported or unconvertible formats.
     * @throws \RuntimeException for unreadable / corrupt files.
     */
    public function import(UploadedFile $file): void
    {
        $extension = strtolower($file->getClientOriginalExtension());

        $parser = $this->resolveParser($extension);
        $rows = $parser->parse($file->getRealPath());

        if (empty($rows)) {
            $this->errors[] = 'File kosong atau tidak dapat dibaca.';

            return;
        }

        $this->processStackedRows($rows);

        $this->syncCounters();
    }

    private function processStackedRows(array $rows): void
    {
        $currentColMap = null;
        $currentVisitDate = null;

        foreach ($rows as $index => $row) {
            $rowNum = $index + 1;

            // Clean up row cells
            $rowCleaned = array_map(function ($val) {
                return trim((string) $val);
            }, $row);

            // Skip empty rows
            if (count(array_filter($rowCleaned, fn ($v) => $v !== '')) === 0) {
                continue;
            }

            // 1. Check if the row contains a date declaration (e.g. "Tanggal: 05 Jan 2026")
            $rowDate = null;
            foreach ($rowCleaned as $cell) {
                if (preg_match('/tanggal\s*(?:pelaksanaan|ukur|periksa)?\s*:?\s*(.+)/i', $cell, $matches)) {
                    $dateStr = trim($matches[1]);
                    $rowDate = $this->parseReportDate($dateStr);
                    if ($rowDate) {
                        $currentVisitDate = $rowDate;
                        break;
                    }
                }
            }

            // 2. Check if the row is a header row
            $isHeader = false;
            foreach ($rowCleaned as $cell) {
                $cellLower = strtolower($cell);
                if (in_array($cellLower, ['nama', 'nama_anak', 'nama anak', 'nama_balita', 'nama balita', 'nik', 'full_name'])) {
                    $isHeader = true;
                    break;
                }
            }

            if ($isHeader) {
                $normalizedHeaders = $this->headerResolver->normalizeHeaders($rowCleaned);
                $currentColMap = $this->headerResolver->buildColumnMap($normalizedHeaders);
                $this->debugHeaders = $rowCleaned;

                continue; // Skip header row itself
            }

            // 3. If we have a header map, process the row as a data row
            if ($currentColMap) {
                $get = function (string $key) use ($rowCleaned, $currentColMap): string {
                    $idx = $currentColMap[$key] ?? null;

                    return $idx !== null ? ($rowCleaned[$idx] ?? '') : '';
                };

                $nama = $get('nama_anak');
                $nik = $get('nik');

                // Skip header duplicates or noise rows
                if (in_array(strtolower($nama), ['nama', 'nama balita', 'nama anak', 'nama warga', 'full name'])) {
                    continue;
                }

                if ($nama === '' && $nik === '') {
                    continue;
                }

                // Process the single row
                $this->rowProcessor->processSingleRow($rowCleaned, $currentColMap, $rowNum, $currentVisitDate);
            }
        }
    }

    // ── Private helpers ───────────────────────────────────────────────

    private function resolveParser(string $extension): FileParserInterface
    {
        return match ($extension) {
            'csv' => new CsvFileParser,
            'xlsx' => new XlsxFileParser,
            'xls' => new XlsFileParser,
            default => throw new \InvalidArgumentException(
                "Format '{$extension}' tidak didukung. Gunakan CSV, XLSX, atau XLS."
            ),
        };
    }

    /**
     * Detect the header row, normalize it, and build the column map.
     *
     * @param  array<int, array<int, string>>  $rows
     * @return array{0: array, 1: array<string, int>}
     */
    private function resolveHeaders(array $rows): array
    {
        $headerRowIndex = $this->headerResolver->findHeaderRowIndex($rows);

        if ($headerRowIndex === null) {
            $headerRowIndex = 0;
            $this->errors[] = 'Peringatan: Header tidak terdeteksi otomatis, menggunakan baris pertama sebagai header.';
        }

        $rawHeaders = $rows[$headerRowIndex];
        $this->debugHeaders = $rawHeaders;

        $normalizedHeaders = $this->headerResolver->normalizeHeaders($rawHeaders);
        $colMap = $this->headerResolver->buildColumnMap($normalizedHeaders);
        $dataRows = array_slice($rows, $headerRowIndex + 1);

        return [$dataRows, $colMap];
    }

    /**
     * Parse report date string supporting both English and Indonesian months.
     */
    private function parseReportDate(string $str): ?Carbon
    {
        $months = [
            'jan' => 1, 'januari' => 1,
            'feb' => 2, 'februari' => 2,
            'mar' => 3, 'maret' => 3,
            'apr' => 4, 'april' => 4,
            'mei' => 5,
            'jun' => 6, 'juni' => 6,
            'jul' => 7, 'juli' => 7,
            'agu' => 8, 'agustus' => 8, 'agt' => 8,
            'sep' => 9, 'september' => 9,
            'okt' => 10, 'oktober' => 10,
            'nov' => 11, 'november' => 11,
            'des' => 12, 'desember' => 12,
        ];

        // 1. DD Month YYYY (e.g. "1 Apr 2026")
        if (preg_match('/^(\d{1,2})\s+(\w+)\s+(\d{4})$/i', $str, $matches)) {
            $day = (int) $matches[1];
            $monthStr = strtolower($matches[2]);
            $year = (int) $matches[3];
            if (isset($months[$monthStr])) {
                return Carbon::createFromDate($year, $months[$monthStr], $day)->startOfDay();
            }
        }

        // 2. Month YYYY (e.g. "April 2026")
        if (preg_match('/^(\w+)\s+(\d{4})$/i', $str, $matches)) {
            $monthStr = strtolower($matches[1]);
            $year = (int) $matches[2];
            if (isset($months[$monthStr])) {
                return Carbon::createFromDate($year, $months[$monthStr], 1)->startOfDay();
            }
        }

        // 3. Try standard Carbon parsing
        try {
            return Carbon::parse($str)->startOfDay();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Copy counters and errors from the row processor back to this orchestrator.
     */
    private function syncCounters(): void
    {
        $this->imported = $this->rowProcessor->imported;
        $this->skipped = $this->rowProcessor->skipped;
        $this->recordsImported = $this->rowProcessor->recordsImported;
        $this->errors = array_merge($this->errors, $this->rowProcessor->errors);
    }
}
