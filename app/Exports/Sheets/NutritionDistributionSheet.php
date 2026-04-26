<?php

namespace App\Exports\Sheets;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NutritionDistributionSheet
{
    protected array $reportData;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function render(Worksheet $sheet): void
    {
        $sheet->setCellValue('A1', 'DISTRIBUSI STATUS GIZI BALITA');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A3', 'Status Gizi');
        $sheet->setCellValue('B3', 'Jumlah');
        $sheet->getStyle('A3:B3')->getFont()->setBold(true);

        $row = 4;
        foreach ($this->reportData['nutrition_distribution'] as $status => $count) {
            $sheet->setCellValue('A' . $row, $status);
            $sheet->setCellValue('B' . $row, $count);
            $row++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
    }
}
