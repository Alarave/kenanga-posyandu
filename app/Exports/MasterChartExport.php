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
 * Export generic master data table for Analytics Charts
 */
class MasterChartExport
{
    protected array $headers;
    protected array $records;
    protected string $title;
    protected string $year;

    public function __construct(array $headers, array $records, string $title, string $year)
    {
        $this->headers = $headers;
        $this->records = $records;
        $this->title = $title;
        $this->year = $year;
    }

    public function generate(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Master Data');

        $colCount = count($this->headers);
        $lastColLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);

        // ── Title Row ──
        $sheet->setCellValue('A1', "{$this->title} — Tahun {$this->year}");
        $sheet->mergeCells("A1:{$lastColLetter}1");
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ── Header Row ──
        $sheet->fromArray([$this->headers], null, 'A3');

        $headerStyle = $sheet->getStyle("A3:{$lastColLetter}3");
        $headerStyle->getFont()->setBold(true)->setColor(new Color('FFFFFFFF'));
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');
        $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $headerStyle->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // ── Data Rows ──
        $row = 4;
        foreach ($this->records as $dataRow) {
            $colIndex = 1;
            foreach ($dataRow as $cellValue) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                
                // If it's NIK, ensure it's saved as explicit string so it doesn't get scientific notation
                if ($this->headers[$colIndex - 1] === 'NIK') {
                    $sheet->setCellValueExplicit("{$colLetter}{$row}", $cellValue ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                } else {
                    $sheet->setCellValue("{$colLetter}{$row}", $cellValue ?? '-');
                }
                
                $colIndex++;
            }

            // Alternate row background
            if ($row % 2 === 0) {
                $sheet->getStyle("A{$row}:{$lastColLetter}{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
            }

            // Borders
            $sheet->getStyle("A{$row}:{$lastColLetter}{$row}")->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('FFE2E8F0'));

            $row++;
        }

        // ── Column widths and alignment ──
        for ($i = 1; $i <= $colCount; $i++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
            $headerName = strtolower($this->headers[$i - 1]);

            // Auto size columns by default, but set fixed width for some common ones
            if (in_array($headerName, ['bulan', 'tanggal', 'unit posyandu', 'kategori warga', 'kategori gizi'])) {
                $sheet->getColumnDimension($colLetter)->setWidth(15);
                $sheet->getStyle("{$colLetter}3:{$colLetter}" . max($row - 1, 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            } elseif ($headerName === 'nik') {
                $sheet->getColumnDimension($colLetter)->setWidth(20);
                $sheet->getStyle("{$colLetter}3:{$colLetter}" . max($row - 1, 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            } elseif (in_array($headerName, ['bb (kg)', 'tb (cm)'])) {
                $sheet->getColumnDimension($colLetter)->setWidth(10);
                $sheet->getStyle("{$colLetter}3:{$colLetter}" . max($row - 1, 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            } elseif ($headerName === 'nama pasien' || str_contains($headerName, 'status / info')) {
                $sheet->getColumnDimension($colLetter)->setAutoSize(true);
            } else {
                // For vaccines or other unknown headers, set standard width and center
                $sheet->getColumnDimension($colLetter)->setWidth(12);
                $sheet->getStyle("{$colLetter}3:{$colLetter}" . max($row - 1, 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        $sheet->setAutoFilter("A3:{$lastColLetter}3");
        $sheet->freezePane('A4');

        return $spreadsheet;
    }

    public function export(string $filePath): void
    {
        $spreadsheet = $this->generate();
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }
}
