<?php

namespace App\Livewire\Admin;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Posyandu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Livewire\Shared\BaseAdminComponent;

class Analytics extends BaseAdminComponent
{
    public int $selectedYear;
    public array $years = [];

    // Overview stats
    public int   $totalBalita      = 0;
    public float $stuntingRate     = 0;
    public float $cakupanImunisasi = 0;
    public int   $kaderAktif       = 0;

    // Trend data (12 bulan)
    public array $trendLabels  = [];
    public array $trendNormal  = [];
    public array $trendStunting = [];

    // Nutrition distribution
    public array $nutritionLabels = [];
    public array $nutritionData   = [];

    // Stunting by posyandu
    public array $stuntingByPosyandu = [];

    // Demographics
    public int $usia0_12  = 0;
    public int $usia12_24 = 0;
    public int $usia24plus = 0;

    // Recent records
    public $recentRecords;

    public function mount(): void
    {
        $this->selectedYear = (int) now()->year;
        $this->years = range($this->selectedYear, max(2020, $this->selectedYear - 4));
        $this->loadData();
    }

    public function updatedSelectedYear(): void
    {
        $this->loadData();
    }

    protected function loadData(): void
    {
        $user = Auth::user();

        // Menggunakan scope dari Trait di BaseAdminComponent
        $patientQuery = $this->applyPosyanduScope(Patient::query());
        $medicalRecordQuery = $this->applyPosyanduScope(MedicalRecord::query());

        // ── Overview Stats ──────────────────────────────────────────
        $this->totalBalita = (clone $patientQuery)->where('category', 'balita')->count();

        // Stunting rate: balita dengan rekam medis terbaru = Gizi Buruk / Stunting
        $totalWithRecord = (clone $patientQuery)
            ->where('category', 'balita')
            ->whereHas('medicalRecords')
            ->count();

        $stuntingCount = (clone $patientQuery)
            ->where('category', 'balita')
            ->whereHas('medicalRecords', fn($q) =>
                $q->whereIn('nutrition_status', ['Gizi Buruk', 'Gizi Buruk/Stunting'])
                  ->whereIn('id', fn($sub) =>
                      $sub->selectRaw('MAX(id)')->from('medical_records')->groupBy('patient_id')
                  )
            )
            ->count();

        $this->stuntingRate = $totalWithRecord > 0
            ? round(($stuntingCount / $totalWithRecord) * 100, 1)
            : 0;

        // Cakupan imunisasi
        $balitaWithImunisasi = (clone $medicalRecordQuery)
            ->whereHas('patient', fn($q) => $q->where('category', 'balita'))
            ->whereNotNull('immunization')
            ->where('immunization', '!=', '')
            ->whereYear('visit_date', $this->selectedYear)
            ->distinct('patient_id')
            ->count('patient_id');

        $this->cakupanImunisasi = $this->totalBalita > 0
            ? round(($balitaWithImunisasi / $this->totalBalita) * 100, 1)
            : 0;

        // Kader aktif
        $this->kaderAktif = User::where('is_active', true)
            ->whereIn('role', ['staff', 'medical', 'admin'])
            ->when(!$user->isSuperAdmin() && $user->posyandu_id, fn($q) =>
                $q->where('posyandu_id', $user->posyandu_id)
            )
            ->count();

        // ── Trend 12 Bulan ──────────────────────────────────────────
        $this->trendLabels   = [];
        $this->trendNormal   = [];
        $this->trendStunting = [];

        for ($m = 1; $m <= 12; $m++) {
            $this->trendLabels[] = Carbon::create($this->selectedYear, $m)->translatedFormat('M');

            $base = (clone $medicalRecordQuery)
                ->whereHas('patient', fn($q) => $q->where('category', 'balita'))
                ->whereYear('visit_date', $this->selectedYear)
                ->whereMonth('visit_date', $m);

            $this->trendNormal[]   = (clone $base)->whereIn('nutrition_status', ['Normal', 'Gizi Baik'])->count();
            $this->trendStunting[] = (clone $base)->whereIn('nutrition_status', ['Gizi Buruk', 'Gizi Buruk/Stunting'])->count();
        }

        // ── Distribusi Status Gizi ───────────────────────────────────
        $dist = (clone $medicalRecordQuery)
            ->whereHas('patient', fn($q) => $q->where('category', 'balita'))
            ->whereYear('visit_date', $this->selectedYear)
            ->whereNotNull('nutrition_status')
            ->select('nutrition_status', DB::raw('COUNT(*) as total'))
            ->groupBy('nutrition_status')
            ->pluck('total', 'nutrition_status')
            ->toArray();

        $this->nutritionLabels = array_keys($dist);
        $this->nutritionData   = array_values($dist);

        // ── Stunting per Posyandu ────────────────────────────────────
        $posyandus = $this->getAllowedPosyandus();

        $this->stuntingByPosyandu = [];
        foreach ($posyandus as $pos) {
            $total = Patient::where('posyandu_id', $pos->id)
                ->where('category', 'balita')
                ->whereHas('medicalRecords')
                ->count();

            $stunting = Patient::where('posyandu_id', $pos->id)
                ->where('category', 'balita')
                ->whereHas('medicalRecords', fn($q) =>
                    $q->whereIn('nutrition_status', ['Gizi Buruk', 'Gizi Buruk/Stunting'])
                      ->whereIn('id', fn($sub) =>
                          $sub->selectRaw('MAX(id)')->from('medical_records')->groupBy('patient_id')
                      )
                )
                ->count();

            $rate = $total > 0 ? round(($stunting / $total) * 100, 1) : 0;

            $this->stuntingByPosyandu[] = [
                'name'     => $pos->name,
                'rate'     => $rate,
                'stunting' => $stunting,
                'total'    => $total,
                'width'    => min(100, $rate * 6),
                'color'    => $rate >= 10 ? 'bg-red-500' : ($rate >= 5 ? 'bg-amber-500' : 'bg-green-500'),
                'text'     => $rate >= 10 ? 'text-red-600' : ($rate >= 5 ? 'text-amber-600' : 'text-green-600'),
            ];
        }

        // ── Demographics ─────────────────────────────────────────────
        $this->usia0_12 = (clone $patientQuery)
            ->where('category', 'balita')
            ->whereRaw('TIMESTAMPDIFF(MONTH, birth_date, CURDATE()) BETWEEN 0 AND 11')
            ->count();

        $this->usia12_24 = (clone $patientQuery)
            ->where('category', 'balita')
            ->whereRaw('TIMESTAMPDIFF(MONTH, birth_date, CURDATE()) BETWEEN 12 AND 23')
            ->count();

        $this->usia24plus = (clone $patientQuery)
            ->where('category', 'balita')
            ->whereRaw('TIMESTAMPDIFF(MONTH, birth_date, CURDATE()) >= 24')
            ->count();

        // ── Recent Records ───────────────────────────────────────────
        $this->recentRecords = (clone $medicalRecordQuery)
            ->with(['patient.posyandu'])
            ->whereHas('patient', fn($q) => $q->where('category', 'balita'))
            ->latest('visit_date')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.analytics');
    }
}
