<?php

namespace App\Services;

use App\Exports\MonthlyReportExport;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Posyandu;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Generate monthly report for a posyandu
     *
     * @param  int  $posyanduId  Posyandu ID
     * @param  int  $month  Month (1-12)
     * @param  int  $year  Year (e.g., 2024)
     * @return array Report data structure
     */
    public function generateMonthlyReport(int $posyanduId, int $month, int $year): array
    {
        $posyandu = Posyandu::findOrFail($posyanduId);

        // Date range for the month
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate)); // Last day of month

        // 1. Kunjungan per kategori
        $visitsByCategory = MedicalRecord::query()
            ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->where('patients.posyandu_id', $posyanduId)
            ->whereBetween('medical_records.visit_date', [$startDate, $endDate])
            ->select('patients.category', DB::raw('COUNT(*) as total'))
            ->groupBy('patients.category')
            ->get()
            ->pluck('total', 'category')
            ->toArray();

        // Ensure all categories are present
        $categories = ['balita', 'ibu_hamil', 'remaja', 'lansia'];
        foreach ($categories as $category) {
            if (! isset($visitsByCategory[$category])) {
                $visitsByCategory[$category] = 0;
            }
        }

        // 2. Distribusi status gizi (hanya untuk balita)
        $nutritionDistribution = MedicalRecord::query()
            ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->where('patients.posyandu_id', $posyanduId)
            ->where('patients.category', 'balita')
            ->whereBetween('medical_records.visit_date', [$startDate, $endDate])
            ->whereNotNull('medical_records.nutrition_status')
            ->select('medical_records.nutrition_status', DB::raw('COUNT(*) as total'))
            ->groupBy('medical_records.nutrition_status')
            ->get()
            ->pluck('total', 'nutrition_status')
            ->toArray();

        // 3. Pemberian Vitamin A
        $vitaminACount = MedicalRecord::query()
            ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->where('patients.posyandu_id', $posyanduId)
            ->whereBetween('medical_records.visit_date', [$startDate, $endDate])
            ->where(function ($q) {
                $q->where('medical_records.vitamin_a', true)
                  ->orWhere('medical_records.vitamin_a_color', '!=', 'none');
            })
            ->count();

        // 4. Pemberian Pill FE
        $pillFeCount = MedicalRecord::query()
            ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->where('patients.posyandu_id', $posyanduId)
            ->whereBetween('medical_records.visit_date', [$startDate, $endDate])
            ->where('medical_records.pill_fe', true)
            ->count();

        // 5. Jadwal kegiatan bulan ini
        $schedules = Schedule::query()
            ->where('posyandu_id', $posyanduId)
            ->whereYear('start_time', $year)
            ->whereMonth('start_time', $month)
            ->orderBy('start_time')
            ->get()
            ->map(function ($schedule) {
                return [
                    'title' => $schedule->title,
                    'date' => $schedule->start_time,
                    'location' => $schedule->location,
                    'status' => $schedule->status,
                ];
            })
            ->toArray();

        // 6. Total sasaran terdaftar per kategori
        $totalPatientsByCategory = Patient::query()
            ->where('posyandu_id', $posyanduId)
            ->select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->get()
            ->pluck('total', 'category')
            ->toArray();

        foreach ($categories as $category) {
            if (! isset($totalPatientsByCategory[$category])) {
                $totalPatientsByCategory[$category] = 0;
            }
        }

        // 7. Data mentah rekam medis (untuk sheet detail)
        $rawRecords = MedicalRecord::query()
            ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->where('patients.posyandu_id', $posyanduId)
            ->whereBetween('medical_records.visit_date', [$startDate, $endDate])
            ->select('medical_records.*', 'patients.full_name', 'patients.id_number', 'patients.category', 'patients.gender')
            ->orderBy('medical_records.visit_date')
            ->get()
            ->toArray();

        // 8. Pokja IV Data
        $pokjaIvData = [
            'rows' => [
                'S' => $this->initAgeGroupArray(),
                'K' => $this->initAgeGroupArray(),
                'N' => $this->initAgeGroupArray(),
                'T' => $this->initAgeGroupArray(),
                'D' => $this->initAgeGroupArray(),
                'B' => $this->initAgeGroupArray(),
                'O' => $this->initAgeGroupArray(),
                'GB' => $this->initAgeGroupArray(),
                'GK' => $this->initAgeGroupArray(),
                'GR' => $this->initAgeGroupArray(),
                'GL' => $this->initAgeGroupArray(),
            ],
            'cohorts' => [
                '0-11_baru' => ['L' => 0, 'P' => 0],
                '12-59_baru' => ['L' => 0, 'P' => 0],
                '12_bln' => ['L' => 0, 'P' => 0],
                '24_bln' => ['L' => 0, 'P' => 0],
                '36_bln' => ['L' => 0, 'P' => 0],
                '48_bln' => ['L' => 0, 'P' => 0],
                '60_bln' => ['L' => 0, 'P' => 0],
                'lulus' => ['L' => 0, 'P' => 0],
            ],
            'kader' => [
                'total' => \App\Models\User::where('posyandu_id', $posyanduId)->where('role', 'kader')->count(),
                'trained' => 0,
                'active' => 0,
            ],
        ];

        // Fill Row S & K
        $allBalitas = Patient::where('posyandu_id', $posyanduId)
            ->where('category', 'balita')
            ->get();
        foreach ($allBalitas as $p) {
            $age = (int) $p->birth_date->diffInMonths($endDate);
            if ($age > 59) {
                continue;
            }
            $this->incrementAgeGroup($pokjaIvData['rows']['S'], $p->gender, $age);
            $this->incrementAgeGroup($pokjaIvData['rows']['K'], $p->gender, $age);
        }

        // Fill other rows from medical records
        $records = MedicalRecord::query()
            ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->where('patients.posyandu_id', $posyanduId)
            ->where('patients.category', 'balita')
            ->whereBetween('medical_records.visit_date', [$startDate, $endDate])
            ->select('medical_records.*', 'patients.birth_date', 'patients.gender')
            ->get();

        foreach ($records as $record) {
            $age = (int) \Carbon\Carbon::parse($record->birth_date)->diffInMonths(\Carbon\Carbon::parse($record->visit_date));
            if ($age > 59) {
                continue;
            }

            $gender = $record->gender;
            $g = (strtoupper(substr($gender, 0, 1)) === 'L' || strtoupper(substr($gender, 0, 1)) === 'M') ? 'L' : 'P';

            // Row D (Datang)
            $this->incrementAgeGroup($pokjaIvData['rows']['D'], $gender, $age);

            // Row N (Naik)
            if ($record->nutrition_trend === 'naik') {
                $this->incrementAgeGroup($pokjaIvData['rows']['N'], $gender, $age);
            }

            // Row T (Tidak Naik)
            if ($record->nutrition_trend === 'turun' || $record->nutrition_trend === 'tetap') {
                $this->incrementAgeGroup($pokjaIvData['rows']['T'], $gender, $age);
            }

            // Row O (Vitamin A)
            if ($record->vitamin_a || $record->vitamin_a_color !== 'none') {
                $this->incrementAgeGroup($pokjaIvData['rows']['O'], $gender, $age);
            }

            // Row GB (Gizi Buruk)
            if ($record->nutrition_status === 'Gizi Buruk') {
                $this->incrementAgeGroup($pokjaIvData['rows']['GB'], $gender, $age);
            }

            // Row GK (Gizi Kurang)
            if ($record->nutrition_status === 'Gizi Kurang') {
                $this->incrementAgeGroup($pokjaIvData['rows']['GK'], $gender, $age);
            }

            // Cohorts Logic
            $isFirstVisit = ! MedicalRecord::where('patient_id', $record->patient_id)
                ->where('visit_date', '<', $record->visit_date)
                ->exists();

            if ($isFirstVisit) {
                if ($age <= 11) {
                    $pokjaIvData['cohorts']['0-11_baru'][$g]++;
                } else {
                    $pokjaIvData['cohorts']['12-59_baru'][$g]++;
                }
            }

            if ($age === 12) {
                $pokjaIvData['cohorts']['12_bln'][$g]++;
            }
            if ($age === 24) {
                $pokjaIvData['cohorts']['24_bln'][$g]++;
            }
            if ($age === 36) {
                $pokjaIvData['cohorts']['36_bln'][$g]++;
            }
            if ($age === 48) {
                $pokjaIvData['cohorts']['48_bln'][$g]++;
            }
            if ($age === 59) {
                $pokjaIvData['cohorts']['60_bln'][$g]++;
            } // Handling 60 as 59 edge

            if ($record->weight >= 11.5) {
                $pokjaIvData['cohorts']['lulus'][$g]++;
            }
        }

        return [
            'posyandu' => [
                'id' => $posyandu->id,
                'name' => $posyandu->name,
                'address' => $posyandu->address,
            ],
            'period' => [
                'month' => $month,
                'year' => $year,
                'month_name' => $this->getMonthName($month),
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'visits_by_category' => $visitsByCategory,
            'total_patients_by_category' => $totalPatientsByCategory,
            'nutrition_distribution' => $nutritionDistribution,
            'vitamin_a_given' => $vitaminACount,
            'pill_fe_given' => $pillFeCount,
            'schedules' => $schedules,
            'total_visits' => array_sum($visitsByCategory),
            'raw_medical_records' => $rawRecords,
            'pokja_iv' => $pokjaIvData,
        ];
    }

    /**
     * Export report data to Excel file (CSV format — no external library needed)
     *
     * @param  array  $reportData  Report data from generateMonthlyReport
     * @param  string  $posyanduName  Posyandu name for filename
     * @return string Path to the generated CSV file
     */
    public function exportToExcel(array $reportData, string $posyanduName): string
    {
        $fileName = sprintf(
            'Laporan_%s_%s_%s.xlsx',
            str_replace([' ', '/'], '_', $posyanduName),
            $reportData['period']['month_name'],
            $reportData['period']['year']
        );

        $directory = storage_path('app/public/exports');
        if (! file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $filePath = $directory.'/'.$fileName;

        // Gunakan export class baru berbasis PhpSpreadsheet
        $export = new MonthlyReportExport($reportData);
        $export->export($filePath);

        return $filePath;
    }

    /**
     * Export report data to PDF file
     *
     * @param  array  $reportData  Report data from generateMonthlyReport
     * @param  string  $posyanduName  Posyandu name for filename
     * @return string Path to the generated PDF file
     */
    public function exportToPdf(array $reportData, string $posyanduName): string
    {
        $fileName = sprintf(
            'Laporan_%s_%s_%s.pdf',
            str_replace(' ', '_', $posyanduName),
            $reportData['period']['month_name'],
            $reportData['period']['year']
        );

        $filePath = 'exports/'.$fileName;

        // Generate PDF using dompdf
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.monthly-report-pdf', [
            'reportData' => $reportData,
        ]);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Save to storage
        $fullPath = storage_path('app/public/'.$filePath);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (! file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $pdf->save($fullPath);

        return $fullPath;
    }

    /**
     * Get Indonesian month name
     *
     * @param  int  $month  Month number (1-12)
     * @return string Month name in Indonesian
     */
    private function getMonthName(int $month): string
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return $months[$month] ?? '';
    }

    /**
     * Inisialisasi array struktur umur Pokja IV.
     */
    private function initAgeGroupArray(): array
    {
        return [
            'male' => ['0-5' => 0, '6-11' => 0, '12-23' => 0, '24-59' => 0, 'total' => 0],
            'female' => ['0-5' => 0, '6-11' => 0, '12-23' => 0, '24-59' => 0, 'total' => 0],
        ];
    }

    /**
     * Increment age group berdasarkan gender dan umur.
     */
    private function incrementAgeGroup(array &$target, string $gender, int $ageInMonths): void
    {
        $normalizedGender = strtoupper(trim($gender));
        $g = ($normalizedGender === 'L' || $normalizedGender === 'M' || $normalizedGender === 'LAKI-LAKI' || $normalizedGender === 'MALE') ? 'male' : 'female';

        if ($ageInMonths <= 5) {
            $target[$g]['0-5']++;
        } elseif ($ageInMonths <= 11) {
            $target[$g]['6-11']++;
        } elseif ($ageInMonths <= 23) {
            $target[$g]['12-23']++;
        } elseif ($ageInMonths <= 59) {
            $target[$g]['24-59']++;
        }

        $target[$g]['total']++;
    }

    /**
     * Generate individual report data for a patient
     */
    public function generateIndividualReportData(Patient $patient, int $startMonth, int $startYear, int $endMonth, int $endYear): array
    {
        $patient->load(['posyandu']);
        
        $startDate = sprintf('%04d-%02d-01', $startYear, $startMonth);
        $endDate = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $endYear, $endMonth)));

        // Get months timeline
        $monthsRange = $this->getMonthsRange($startMonth, $startYear, $endMonth, $endYear);

        // Get medical records within range
        $records = MedicalRecord::where('patient_id', $patient->id)
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->orderBy('visit_date', 'asc')
            ->get();

        // Get all unique vaccines received by the child overall
        $immunizationStatus = $patient->getImmunizationStatus();

        // Prepare vaccine records in this specific period
        $vaccinesGivenInPeriod = [];
        foreach ($records as $record) {
            if ($record->vaccine_name) {
                $vaccinesGivenInPeriod[] = [
                    'date' => $record->visit_date->format('d M Y'),
                    'name' => $record->vaccine_name,
                    'dose' => $record->vaccine_dose ?? '1',
                ];
            }
        }

        // Prepare vitamin details
        $vitaminGivenInPeriod = [];
        foreach ($records as $record) {
            if ($record->vitamin_a || ($record->vitamin_a_color && $record->vitamin_a_color !== 'none')) {
                $vitaminGivenInPeriod[] = [
                    'date' => $record->visit_date->format('d M Y'),
                    'color' => $record->vitamin_a_color ?? 'none',
                    'note' => $record->vitamin_a_color === 'red' ? 'Kapsul Merah (A) 200.000 IU' : ($record->vitamin_a_color === 'blue' ? 'Kapsul Biru (A) 100.000 IU' : 'Vitamin A'),
                ];
            }
        }

        // Map records to monthly slots
        $monthlyRecords = [];
        foreach ($monthsRange as $monthSlot) {
            $monthKey = $monthSlot['key'];
            // Find record for this month
            $recordForMonth = $records->first(function ($r) use ($monthSlot) {
                return $r->visit_date->format('Y-m') === $monthSlot['key'];
            });
            
            $monthlyRecords[$monthKey] = [
                'period' => $monthSlot,
                'record' => $recordForMonth ? [
                    'id' => $recordForMonth->id,
                    'visit_date' => $recordForMonth->visit_date->format('d M Y'),
                    'weight' => $recordForMonth->weight,
                    'height' => $recordForMonth->height,
                    'head_circumference' => $recordForMonth->head_circumference,
                    'upper_arm_circumference' => $recordForMonth->upper_arm_circumference,
                    'nutrition_status' => $recordForMonth->nutrition_status,
                    'stunting_status' => $recordForMonth->stunting_status,
                    'wasting_status' => $recordForMonth->wasting_status,
                    'nutrition_trend' => $recordForMonth->nutrition_trend,
                    'vitamin_a' => $recordForMonth->vitamin_a,
                    'pill_fe' => $recordForMonth->pill_fe,
                    'vaccine_name' => $recordForMonth->vaccine_name,
                    'complaint' => $recordForMonth->complaint,
                    'health_note' => $recordForMonth->health_note,
                ] : null,
            ];
        }

        // Generate SVG Charts for weight and height (using ALL records for WHO standard)
        $allRecords = MedicalRecord::where('patient_id', $patient->id)->orderBy('visit_date', 'asc')->get();
        $svgCharts = $this->generateIndividualSvgCharts($patient, $allRecords);

        $periodLabel = $this->getMonthName($startMonth) . ' ' . $startYear;
        if ($startMonth !== $endMonth || $startYear !== $endYear) {
            $periodLabel .= ' - ' . $this->getMonthName($endMonth) . ' ' . $endYear;
        }

        return [
            'patient' => [
                'id' => $patient->id,
                'full_name' => $patient->full_name,
                'id_number' => $patient->id_number,
                'category' => $patient->category,
                'gender' => $patient->gender,
                'birth_date' => $patient->birth_date ? $patient->birth_date->format('d M Y') : '-',
                'birth_date_raw' => $patient->birth_date,
                'age' => $patient->age,
                'father_name' => $patient->father_name ?? '-',
                'mother_name' => $patient->mother_name ?? '-',
                'address' => $patient->address ?? '-',
                'phone_number' => $patient->phone_number ?? '-',
                'posyandu_name' => $patient->posyandu->name ?? '-',
            ],
            'period' => [
                'start_month' => $startMonth,
                'start_year' => $startYear,
                'end_month' => $endMonth,
                'end_year' => $endYear,
            ],
            'period_label' => $periodLabel,
            'months_range' => $monthsRange,
            'monthly_records' => $monthlyRecords,
            'raw_records' => $records->toArray(),
            'vaccines_in_period' => $vaccinesGivenInPeriod,
            'vitamins_in_period' => $vitaminGivenInPeriod,
            'immunization_status' => $immunizationStatus,
            'svg_charts' => $svgCharts,
        ];
    }

    /**
     * Generate individual SVG charts for weight and height using WHO Standards
     */
    public function generateIndividualSvgCharts(Patient $patient, \Illuminate\Database\Eloquent\Collection $records): array
    {
        // Dimensions
        $width = 540;
        $height = 200;
        $paddingLeft = 35;
        $paddingRight = 15;
        $paddingTop = 15;
        $paddingBottom = 25;
        
        $chartW = $width - $paddingLeft - $paddingRight;
        $chartH = $height - $paddingTop - $paddingBottom;

        $gender = ($patient->gender === 'L' || $patient->gender === 'M' || strtoupper($patient->gender) === 'LAKI-LAKI') ? 'M' : 'F';

        // Get WHO References
        $weightRefs = \App\Models\WhoWeightForAge::where('gender', $gender)->where('age_months', '<=', 60)->orderBy('age_months')->get();
        $heightRefs = \App\Models\WhoHeightForAge::where('gender', $gender)->where('age_months', '<=', 60)->orderBy('age_months')->get();

        $generateSvg = function(string $type, $refs) use ($patient, $records, $width, $height, $paddingLeft, $paddingRight, $paddingTop, $paddingBottom, $chartW, $chartH) {
            $minY = $type === 'weight' ? 0 : 40;
            
            // Calculate dynamic maxY to prevent offside data
            $maxData = $type === 'weight' ? 25 : 120;
            foreach ($records as $rec) {
                if ((float)$rec->$type > $maxData) {
                    $maxData = ceil((float)$rec->$type);
                }
            }
            $maxY = $type === 'weight' ? max(25, $maxData + 3) : max(120, $maxData + 5);
            $yTicksCount = 5;

            $getX = function(int $ageMonth) use ($paddingLeft, $chartW) {
                return $paddingLeft + ($ageMonth / 60) * $chartW;
            };

            $getY = function(float $val) use ($paddingTop, $chartH, $minY, $maxY) {
                $val = max($minY, min($maxY, $val)); // clamp
                return $paddingTop + $chartH - (($val - $minY) / ($maxY - $minY)) * $chartH;
            };

            $svg = '<svg viewBox="0 0 ' . $width . ' ' . $height . '" width="' . $width . '" height="' . $height . '" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" style="background:#ffffff; font-family:sans-serif;">';
            
            // Draw Y-axis grid & labels
            for ($k = 0; $k <= $yTicksCount; $k++) {
                $tickVal = $minY + ($k / $yTicksCount) * ($maxY - $minY);
                $ty = $getY($tickVal);
                $svg .= '<line x1="' . $paddingLeft . '" y1="' . $ty . '" x2="' . ($width - $paddingRight) . '" y2="' . $ty . '" stroke="#f1f5f9" stroke-width="1" />';
                $svg .= '<text x="' . ($paddingLeft - 5) . '" y="' . ($ty + 3) . '" fill="#64748b" font-size="8" text-anchor="end">' . round($tickVal) . '</text>';
            }

            // Draw X-axis grid & labels (Every 6 months)
            for ($m = 0; $m <= 60; $m += 6) {
                $tx = $getX($m);
                $svg .= '<line x1="' . $tx . '" y1="' . $paddingTop . '" x2="' . $tx . '" y2="' . ($height - $paddingBottom) . '" stroke="#f8fafc" stroke-width="1" />';
                $svg .= '<text x="' . $tx . '" y="' . ($height - $paddingBottom + 12) . '" fill="#64748b" font-size="8" text-anchor="middle">' . $m . '</text>';
            }
            $svg .= '<text x="' . ($width / 2) . '" y="' . ($height - 5) . '" fill="#475569" font-size="8" text-anchor="middle" font-weight="bold">Umur (Bulan)</text>';

            // Function to draw WHO bands
            $drawBand = function($field, $color, $strokeWidth = 1, $dash = '') use ($refs, $getX, $getY, $type) {
                $points = [];
                foreach ($refs as $r) {
                    $val = $type === 'height' && $field === 'median' ? $r->m_value : $r->$field;
                    if ($val) $points[] = $getX($r->age_months) . ',' . $getY($val);
                }
                $dashAttr = $dash ? 'stroke-dasharray="' . $dash . '"' : '';
                return '<polyline points="' . implode(' ', $points) . '" fill="none" stroke="' . $color . '" stroke-width="' . $strokeWidth . '" ' . $dashAttr . ' stroke-linejoin="round" />';
            };

            // Draw SD curves
            $svg .= $drawBand('sd_plus3', '#cbd5e1', 1);
            $svg .= $drawBand('sd_minus3', '#cbd5e1', 1);
            $svg .= $drawBand('sd_plus2', '#fca5a5', 1, '4 4'); // Red dashed
            $svg .= $drawBand('sd_minus2', '#fca5a5', 1, '4 4'); // Red dashed
            $svg .= $drawBand('median', '#22c55e', 2); // Green median

            // Child Data
            $childPoints = [];
            foreach ($records as $rec) {
                $age = (int) $patient->birth_date->diffInMonths($rec->visit_date);
                if ($age <= 60 && $rec->$type > 0) {
                    $cx = $getX($age);
                    $cy = $getY((float) $rec->$type);
                    $childPoints[] = ['x' => $cx, 'y' => $cy, 'val' => $rec->$type];
                }
            }

            // Draw Child Line
            if (count($childPoints) > 1) {
                $poly = [];
                foreach ($childPoints as $p) {
                    $poly[] = $p['x'] . ',' . $p['y'];
                }
                $svg .= '<polyline points="' . implode(' ', $poly) . '" fill="none" stroke="#0f172a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />';
            }

            // Draw Child Points
            foreach ($childPoints as $p) {
                $svg .= '<circle cx="' . $p['x'] . '" cy="' . $p['y'] . '" r="3" fill="#0f172a" stroke="#ffffff" stroke-width="1" />';
                // Only label the last point to avoid clutter
                if ($p === end($childPoints)) {
                    $svg .= '<rect x="' . ($p['x'] - 12) . '" y="' . ($p['y'] - 18) . '" width="24" height="12" fill="#0f172a" rx="2" />';
                    $svg .= '<text x="' . $p['x'] . '" y="' . ($p['y'] - 9) . '" fill="#ffffff" font-size="7" font-weight="bold" text-anchor="middle">' . $p['val'] . '</text>';
                }
            }

            // Border axis
            $svg .= '<line x1="' . $paddingLeft . '" y1="' . $paddingTop . '" x2="' . $paddingLeft . '" y2="' . ($height - $paddingBottom) . '" stroke="#94a3b8" stroke-width="1.5" />';
            $svg .= '<line x1="' . $paddingLeft . '" y1="' . ($height - $paddingBottom) . '" x2="' . ($width - $paddingRight) . '" y2="' . ($height - $paddingBottom) . '" stroke="#94a3b8" stroke-width="1.5" />';

            $svg .= '</svg>';
            return $svg;
        };

        return [
            'weight' => $generateSvg('weight', $weightRefs),
            'height' => $generateSvg('height', $heightRefs),
        ];
    }

    /**
     * Export individual report data to PDF file
     */
    public function exportIndividualToPdf(array $reportData): string
    {
        $fileName = sprintf(
            'Rapor_Perkembangan_%s_%s.pdf',
            str_replace([' ', '/'], '_', $reportData['patient']['full_name']),
            str_replace([' ', '/'], '_', $reportData['period_label'])
        );

        $filePath = 'exports/'.$fileName;
        $fullPath = storage_path('app/public/'.$filePath);

        $directory = dirname($fullPath);
        if (! file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate PDF using dompdf
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.individual-report-pdf', [
            'reportData' => $reportData,
        ]);

        $pdf->setPaper('A4', 'portrait');
        $pdf->save($fullPath);

        return $fullPath;
    }

    /**
     * Export individual report data to Excel file
     */
    public function exportIndividualToExcel(array $reportData): string
    {
        $fileName = sprintf(
            'Rapor_Perkembangan_%s_%s.xlsx',
            str_replace([' ', '/'], '_', $reportData['patient']['full_name']),
            str_replace([' ', '/'], '_', $reportData['period_label'])
        );

        $directory = storage_path('app/public/exports');
        if (! file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $filePath = $directory.'/'.$fileName;

        $export = new \App\Exports\IndividualReportExport($reportData);
        $export->export($filePath);

        return $filePath;
    }

    /**
     * Get months range between start and end month/year
     */
    private function getMonthsRange(int $startMonth, int $startYear, int $endMonth, int $endYear): array
    {
        $months = [];
        $current = \Carbon\Carbon::create($startYear, $startMonth, 1);
        $end = \Carbon\Carbon::create($endYear, $endMonth, 1);
        
        while ($current->lte($end)) {
            $months[] = [
                'key' => $current->format('Y-m'),
                'label' => $this->getMonthName($current->month) . ' ' . $current->year,
                'short_label' => substr($this->getMonthName($current->month), 0, 3) . ' ' . substr($current->year, 2, 2),
                'month' => $current->month,
                'year' => $current->year,
            ];
            $current->addMonth();
        }
        return $months;
    }
}
