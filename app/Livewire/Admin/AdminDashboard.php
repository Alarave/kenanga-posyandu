<?php

namespace App\Livewire\Admin;

use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Schedule;
use App\Livewire\Shared\BaseAdminComponent;
use Carbon\Carbon;

class AdminDashboard extends BaseAdminComponent
{
    // Properties untuk statistik
    public $totalBalita;
    public $totalIbuHamil;
    public $totalRemaja;
    public $totalLansia;
    public $jadwalAktif;
    public $kunjunganBaru;
    public $balitaStunting;
    public $nutritionStatusDistribution;
    public $monthlyWeighingData;
    public $upcomingSchedule;
    public $recentActivities;
    public $posyanduStats = [];

    public function mount()
    {
        $this->loadStatistics();
    }

    protected function loadStatistics()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Terapkan scope posyandu menggunakan Trait di BaseAdminComponent
        $patientQuery = $this->applyPosyanduScope(Patient::query());
        $scheduleQuery = $this->applyPosyanduScope(Schedule::query());
        $medicalRecordQuery = $this->applyPosyanduScope(MedicalRecord::query());

        // Statistik Utama
        $this->totalBalita = (clone $patientQuery)->where('category', 'balita')->count();
        $this->totalIbuHamil = (clone $patientQuery)->where('category', 'ibu_hamil')->count();
        $this->totalRemaja = (clone $patientQuery)->where('category', 'remaja')->count();
        $this->totalLansia = (clone $patientQuery)->where('category', 'lansia')->count();
        
        $this->jadwalAktif = (clone $scheduleQuery)
            ->whereMonth('start_time', $currentMonth)
            ->whereYear('start_time', $currentYear)
            ->count();

        $this->kunjunganBaru = (clone $medicalRecordQuery)
            ->whereMonth('visit_date', $currentMonth)
            ->whereYear('visit_date', $currentYear)
            ->count();

        // Balita Stunting (Logic spesifik gizi buruk/stunting)
        $this->balitaStunting = (clone $patientQuery)
            ->where('category', 'balita')
            ->whereHas('medicalRecords', function ($query) {
                $query->whereIn('nutrition_status', ['Gizi Buruk', 'Gizi Buruk/Stunting'])
                    ->whereIn('id', function ($subQuery) {
                        $subQuery->selectRaw('MAX(id)')
                            ->from('medical_records')
                            ->groupBy('patient_id');
                    });
            })
            ->with(['medicalRecords' => fn($q) => $q->latest('visit_date')->limit(1)])
            ->get();

        // Grafik Data
        $this->nutritionStatusDistribution = $this->getNutritionStatusDistribution($medicalRecordQuery);
        $this->monthlyWeighingData = $this->getMonthlyWeighingData($medicalRecordQuery);

        // Jadwal Terdekat
        $this->upcomingSchedule = (clone $scheduleQuery)
            ->where('start_time', '>=', Carbon::now())
            ->orderBy('start_time')
            ->first();

        // Aktivitas Terkini
        $this->recentActivities = (clone $medicalRecordQuery)
            ->with(['patient', 'patient.posyandu', 'user'])
            ->latest('visit_date')
            ->latest('created_at')
            ->limit(5)
            ->get();

        // Breakdown per Posyandu (khusus SuperAdmin)
        if (auth()->user()->isSuperAdmin()) {
            $this->posyanduStats = \App\Models\Posyandu::withCount(['patients' => function($query) {
                // Bisa ditambahkan filter jika perlu
            }])->get();
        }
    }

    protected function getNutritionStatusDistribution($medicalRecordQuery)
    {
        $latestRecords = (clone $medicalRecordQuery)
            ->whereHas('patient', fn($q) => $q->where('category', 'balita'))
            ->whereNotNull('nutrition_status')
            ->get()
            ->groupBy('patient_id')
            ->map(fn($records) => $records->sortByDesc('visit_date')->first());

        $distribution = $latestRecords->groupBy('nutrition_status')->map(fn($group) => $group->count());

        return [
            'labels' => $distribution->keys()->toArray(),
            'data' => $distribution->values()->toArray(),
        ];
    }

    protected function getMonthlyWeighingData($medicalRecordQuery)
    {
        $months = [];
        $counts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M Y');
            $count = (clone $medicalRecordQuery)
                ->whereMonth('visit_date', $date->month)
                ->whereYear('visit_date', $date->year)
                ->count();

            $months[] = $month;
            $counts[] = $count;
        }

        return ['labels' => $months, 'data' => $counts];
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
