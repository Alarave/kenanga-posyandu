<?php

namespace App\Exports\Sheets;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Carbon;

class RawMedicalRecordsSheet
{
    protected array $reportData;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function render(Worksheet $sheet): void
    {
        $sheet->setCellValue('A1', 'DATA MENTAH REKAM MEDIS');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $headers = [
            'Tanggal Kunjung', 'Nama Pasien', 'NIK', 'Kategori', 'Gender',
            'BB (kg)', 'TB (cm)', 'Lila/Lika', 'Status Gizi', 'Z-Score BB/U',
            'Status Stunting', 'Z-Score TB/U', 'Status Wasting', 'Z-Score BB/TB',
            'Imunisasi', 'Vitamin A', 'Pill FE', 'Keluhan'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '3', $header);
            $sheet->getStyle($col . '3')->getFont()->setBold(true);
            $col++;
        }

        $row = 4;
        foreach ($this->reportData['raw_medical_records'] ?? [] as $record) {
            $sheet->setCellValue('A' . $row, Carbon::parse($record['visit_date'])->format('d/m/Y'));
            $sheet->setCellValue('B' . $row, $record['full_name']);
            $sheet->setCellValue('C' . $row, $record['id_number']);
            $sheet->setCellValue('D' . $row, ucfirst($record['category']));
            $sheet->setCellValue('E' . $row, $record['gender']);
            $sheet->setCellValue('F' . $row, $record['weight']);
            $sheet->setCellValue('G' . $row, $record['height']);
            $sheet->setCellValue('H' . $row, $record['head_circumference']);
            $sheet->setCellValue('I' . $row, $record['nutrition_status']);
            $sheet->setCellValue('J' . $row, $record['z_score']);
            $sheet->setCellValue('K' . $row, $record['stunting_status'] ?? '-');
            $sheet->setCellValue('L' . $row, $record['z_score_hfa'] ?? '-');
            $sheet->setCellValue('M' . $row, $record['wasting_status'] ?? '-');
            $sheet->setCellValue('N' . $row, $record['z_score_wfh'] ?? '-');
            $sheet->setCellValue('O' . $row, $record['immunization']);
            $sheet->setCellValue('P' . $row, $record['vitamin_a'] ? 'Ya' : 'Tidak');
            $sheet->setCellValue('Q' . $row, $record['pill_fe'] ? 'Ya' : 'Tidak');
            $sheet->setCellValue('R' . $row, $record['complaint']);
            $row++;
        }

        $lastCol = $sheet->getHighestColumn();
        foreach (range('A', $lastCol) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
