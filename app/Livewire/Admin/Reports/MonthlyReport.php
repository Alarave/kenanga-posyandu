<?php

namespace App\Livewire\Admin\Reports;

use App\Livewire\Shared\BaseAdminComponent;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Posyandu;
use App\Services\ActivityLogService;
use App\Services\ReportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MonthlyReport extends BaseAdminComponent
{
    public int $startMonth;

    public int $startYear;

    public int $endMonth;

    public int $endYear;

    public string $startPeriod;

    public string $endPeriod;

    public ?int $selectedPosyanduId = null;

    public bool $reportGenerated = false;

    public string $sortBy = 'visit_date_desc';

    public string $search = '';

    public ?string $filterCategory = '';

    public ?int $filterMonth = null;

    // Stats
    public int $totalKunjungan = 0;

    public int $balitaStunting = 0;

    public int $totalIbuHamil = 0;

    public int $totalLansia = 0;

    public float $cakupanVitaminA = 0;

    public function mount(): void
    {
        $now = now();
        $this->endMonth = (int) $now->month;
        $this->endYear = (int) $now->year;

        // Default ke 6 bulan sebelumnya
        $sixMonthsAgo = $now->subMonths(6);
        $this->startMonth = (int) $sixMonthsAgo->month;
        $this->startYear = (int) $sixMonthsAgo->year;

        $user = Auth::user();
        if ($user->isSuperAdmin()) {
            $this->selectedPosyanduId = Posyandu::first()?->id;
        } else {
            $this->selectedPosyanduId = $user->posyandu_id;
        }

        $this->startPeriod = sprintf('%04d-%02d', $this->startYear, $this->startMonth);
        $this->endPeriod = sprintf('%04d-%02d', $this->endYear, $this->endMonth);

        $this->reportGenerated = true;
        $this->loadStats();
    }

    public function updatedStartPeriod($value)
    {
        if ($value) {
            [$year, $month] = explode('-', $value);
            $this->startYear = (int) $year;
            $this->startMonth = (int) $month;
        }
    }

    public function updatedEndPeriod($value)
    {
        if ($value) {
            [$year, $month] = explode('-', $value);
            $this->endYear = (int) $year;
            $this->endMonth = (int) $month;
        }
    }

    public function updatedFilterCategory(): void
    {
        $this->resetPage();
    }

    public function updatedFilterMonth(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedPosyanduId(): void
    {
        $this->resetPage();
        $this->loadStats();
    }

    public function generateReport(): void
    {
        $this->resetPage();
        $this->reportGenerated = true;
        $this->loadStats();
    }

    protected function loadStats(): void
    {
        $posyanduId = $this->getEffectivePosyanduId();

        $basePatientQuery = Patient::query();
        $baseRecordQuery = MedicalRecord::query();

        if ($posyanduId) {
            $basePatientQuery->where('posyandu_id', $posyanduId);
            $baseRecordQuery->whereHas('patient', fn ($q) => $q->where('posyandu_id', $posyanduId));
        }

        // Get date range
        $startDate = sprintf('%04d-%02d-01', $this->startYear, $this->startMonth);
        $endDate = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $this->endYear, $this->endMonth)));

        $this->totalKunjungan = (clone $baseRecordQuery)
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->count();

        $this->balitaStunting = (clone $basePatientQuery)
            ->where('category', 'balita')
            ->whereHas('medicalRecords', function ($q) use ($startDate, $endDate) {
                $q->whereIn('nutrition_status', ['Gizi Buruk', 'Gizi Buruk/Stunting'])
                    ->whereBetween('visit_date', [$startDate, $endDate]);
            })
            ->count();

        $this->totalIbuHamil = (clone $basePatientQuery)->where('category', 'ibu_hamil')->count();
        $this->totalLansia = (clone $basePatientQuery)->where('category', 'lansia')->count();

        $totalBalitaKunjungan = (clone $baseRecordQuery)
            ->whereHas('patient', fn ($q) => $q->where('category', 'balita'))
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->count();

        $vitaminADiberikan = (clone $baseRecordQuery)
            ->whereHas('patient', fn ($q) => $q->where('category', 'balita'))
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->where('vitamin_a', true)
            ->count();

        $this->cakupanVitaminA = $totalBalitaKunjungan > 0
            ? round(($vitaminADiberikan / $totalBalitaKunjungan) * 100, 1)
            : 0;
    }

    public function exportExcel(ReportService $reportService, ActivityLogService $activityLogService): void
    {
        $posyanduId = $this->getEffectivePosyanduId();
        if (! $posyanduId) {
            return;
        }

        try {
            $posyandu = Posyandu::findOrFail($posyanduId);
            $reportData = $reportService->generateMonthlyReport($posyanduId, $this->endMonth, $this->endYear);
            $filePath = $reportService->exportToExcel($reportData, $posyandu->name);

            $activityLogService->log(
                'export_report',
                "Ekspor laporan Excel: {$posyandu->name} - {$reportData['period']['month_name']} {$reportData['period']['year']}",
                $posyanduId,
                'Posyandu'
            );

            $this->dispatch('download-file', url: asset('storage/exports/'.basename($filePath)));
            $this->notify('Ekspor berhasil. Berkas sedang diunduh.');
        } catch (\Exception $e) {
            Log::error('Export Excel failed: '.$e->getMessage());
            $this->notify('Ekspor gagal. Silakan coba lagi.', 'error');
        }
    }

    public function exportPdf(ReportService $reportService, ActivityLogService $activityLogService)
    {
        $posyanduId = $this->getEffectivePosyanduId();
        if (! $posyanduId) {
            return;
        }

        try {
            $posyandu = Posyandu::findOrFail($posyanduId);
            $reportData = $reportService->generateMonthlyReport($posyanduId, $this->endMonth, $this->endYear);
            $filePath = $reportService->exportToPdf($reportData, $posyandu->name);

            $activityLogService->log(
                'export_report',
                "Ekspor laporan PDF: {$posyandu->name} - {$reportData['period']['month_name']} {$reportData['period']['year']}",
                $posyanduId,
                'Posyandu'
            );

            return response()->download($filePath);
        } catch (\Exception $e) {
            Log::error('Export PDF failed: '.$e->getMessage());
            $this->notify('Ekspor gagal. Silakan coba lagi.', 'error');
        }
    }

    protected function getEffectivePosyanduId(): ?int
    {
        $user = Auth::user();
        if ($user->isSuperAdmin()) {
            return $this->selectedPosyanduId;
        }

        return $user->posyandu_id;
    }

    public function getMonthNameProperty(?int $month = null): string
    {
        $month = $month ?? $this->endMonth;
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return $months[$month] ?? '';
    }

    public function getPosyanduNameProperty(): string
    {
        $id = $this->getEffectivePosyanduId();

        return $id ? (Posyandu::find($id)?->name ?? '-') : '-';
    }

    public function render()
    {
        $posyanduId = $this->getEffectivePosyanduId();
        $records = collect();
        $total = 0;

        if ($this->reportGenerated) {
            $startDate = sprintf('%04d-%02d-01', $this->startYear, $this->startMonth);
            $endDate = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $this->endYear, $this->endMonth)));

            $query = MedicalRecord::with(['patient', 'user', 'patient.posyandu'])
                ->whereHas('patient', fn ($q) => $q->whereIn('category', ['bayi', 'baduta', 'balita', 'ibu_hamil', 'lansia']))
                ->whereBetween('visit_date', [$startDate, $endDate]);

            if ($posyanduId) {
                $query->whereHas('patient', fn ($q) => $q->where('posyandu_id', $posyanduId));
            }

            // Apply search filter
            if ($this->search) {
                $query->whereHas('patient', function ($q) {
                    $searchTerm = '%'.strtolower($this->search).'%';
                    $q->whereRaw('LOWER(full_name) LIKE ?', [$searchTerm])
                        ->orWhere('id_number_hash', Patient::generateBlindIndex($this->search))
                        ->orWhereRaw('LOWER(id_number) LIKE ?', [$searchTerm]);
                });
            }

            // Apply category filter
            if ($this->filterCategory) {
                if ($this->filterCategory === 'balita') {
                    $query->whereHas('patient', fn ($q) => $q->whereIn('category', ['bayi', 'baduta', 'balita']));
                } else {
                    $query->whereHas('patient', fn ($q) => $q->where('category', $this->filterCategory));
                }
            }

            // Apply month filter
            if ($this->filterMonth) {
                $query->whereMonth('visit_date', $this->filterMonth);
            }

            // Apply sorting
            $query = match ($this->sortBy) {
                'patient_name_asc' => $query->join('patients', 'medical_records.patient_id', '=', 'patients.id')->orderBy('patients.full_name', 'asc')->select('medical_records.*'),
                'patient_name_desc' => $query->join('patients', 'medical_records.patient_id', '=', 'patients.id')->orderBy('patients.full_name', 'desc')->select('medical_records.*'),
                'visit_date_asc' => $query->orderBy('visit_date', 'asc'),
                'visit_date_desc' => $query->orderBy('visit_date', 'desc'),
                'updated_at_asc' => $query->orderBy('updated_at', 'asc'),
                'updated_at_desc' => $query->orderBy('updated_at', 'desc'),
                default => $query->latest('visit_date'),
            };

            $total = $query->count();
            $records = $query->paginate(10);
        }

        $periodLabel = $this->getMonthNameProperty($this->startMonth).' '.$this->startYear;
        if ($this->startMonth !== $this->endMonth || $this->startYear !== $this->endYear) {
            $periodLabel .= ' - '.$this->getMonthNameProperty($this->endMonth).' '.$this->endYear;
        }

        return view('livewire.admin.reports.monthly-report', [
            'records' => $records,
            'total' => $total,
            'posyandus' => $this->getAllowedPosyandus(),
            'periodLabel' => $periodLabel,
            'posyanduName' => $this->getPosyanduNameProperty(),
        ]);
    }
}
