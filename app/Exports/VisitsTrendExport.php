<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Export data detail kunjungan dari grafik "Tren Kunjungan Bulanan Gabungan".
 *
 * Kolom: Bulan | Nama | NIK | Kategori | Tanggal Kunjungan | Aksi Lihat
 */
class VisitsTrendExport
{
    protected Collection $records;

    protected int $year;

    protected string $baseUrl;

    public function __construct(Collection $records, int $year, string $baseUrl)
    {
        $this->records = $records;
        $this->year = $year;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Map patient category to display label.
     */
    protected function mapCategory(?string $category): string
    {
        return match ($category) {
            'balita', 'bayi', 'baduta' => 'Balita',
            'ibu_hamil' => 'Ibu Hamil',
            'lansia' => 'Lansia',
            default => ucfirst($category ?? '-'),
        };
    }

    /**
     * Generate the Spreadsheet object.
     */
    public function generate(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Kunjungan');

        // ── Title Row ──
        $sheet->setCellValue('A1', "Data Kunjungan Bulanan Gabungan — Tahun {$this->year}");
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ── Header Row ──
        $headers = ['Bulan', 'Nama', 'NIK', 'Kategori', 'Tanggal Kunjungan', 'Aksi Lihat'];
        $sheet->fromArray([$headers], null, 'A3');

        $headerStyle = $sheet->getStyle('A3:F3');
        $headerStyle->getFont()->setBold(true)->setColor(new Color('FFFFFFFF'));
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');
        $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $headerStyle->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // ── Data Rows ──
        $row = 4;
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        foreach ($this->records as $record) {
            $patient = $record->patient;
            if (! $patient) {
                continue;
            }

            $monthNum = $record->visit_date ? $record->visit_date->month : 0;
            $monthName = $months[$monthNum] ?? '-';

            $sheet->setCellValue("A{$row}", $monthName);
            $sheet->setCellValue("B{$row}", $patient->full_name ?? '-');
            // Force NIK as text so Excel doesn't convert to scientific notation
            $sheet->setCellValueExplicit("C{$row}", $patient->id_number ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue("D{$row}", $this->mapCategory($patient->category));
            $sheet->setCellValue("E{$row}", $record->visit_date ? $record->visit_date->format('d/m/Y') : '-');

            // Aksi Lihat — hyperlink ke halaman pasien
            $patientUrl = $this->baseUrl . '/admin/patients/' . $patient->id;
            $sheet->setCellValue("F{$row}", 'Lihat Detail');
            $sheet->getCell("F{$row}")->getHyperlink()->setUrl($patientUrl);
            $sheet->getStyle("F{$row}")->getFont()->setColor(new Color('FF2563EB'))->setUnderline(true);

            // Alternate row background
            if ($row % 2 === 0) {
                $sheet->getStyle("A{$row}:F{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
            }

            // Borders
            $sheet->getStyle("A{$row}:F{$row}")->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('FFE2E8F0'));

            $row++;
        }

        // ── Column widths ──
        $sheet->getColumnDimension('A')->setWidth(14);  // Bulan
        $sheet->getColumnDimension('B')->setAutoSize(true); // Nama
        $sheet->getColumnDimension('C')->setWidth(20);  // NIK
        $sheet->getColumnDimension('D')->setWidth(14);  // Kategori
        $sheet->getColumnDimension('E')->setWidth(18);  // Tanggal Kunjungan
        $sheet->getColumnDimension('F')->setWidth(16);  // Aksi Lihat

        // Center alignment for certain columns
        $lastRow = max($row - 1, 3);
        $sheet->getStyle("A3:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D3:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("E3:E{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("F3:F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Auto-filter on headers
        $sheet->setAutoFilter("A3:F3");

        // Freeze header row
        $sheet->freezePane('A4');

        return $spreadsheet;
    }

    /**
     * Export to file path.
     */
    public function export(string $filePath): void
    {
        $spreadsheet = $this->generate();
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }
}
