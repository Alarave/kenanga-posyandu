<?php

namespace App\Livewire\Admin\Analytics;

use App\Livewire\Traits\HasPosyanduScope;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class LansiaAnalytics extends Component
{
    use HasPosyanduScope;

    #[Reactive]
    public $selectedYear;

    #[Reactive]
    public $selectedMonth;

    #[Reactive]
    public $selectedPosyandu;

    // Expose stats as public properties for test access
    public $ageCategories = [];
    public $imtStats = [];
    public $metabolicRisks = [];
    public $sensoryObesityStats = [];
    public $specialScreeningReferralStats = [];

    /**
     * Single cached collection of latest lansia records per patient.
     * Loaded once per render cycle, shared across all metric calculations.
     */
    private $cachedRecords = null;

    private $cachedPatients = null;

    /**
     * Load lansia medical records ONCE — replaces 4 duplicate DB queries.
     * Selects only the columns needed across all metric calculations.
     */
    private function getLatestRecords()
    {
        if ($this->cachedRecords !== null) {
            return $this->cachedRecords;
        }

        $this->cachedRecords = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->with(['patient:id,gender,birth_date,full_name,posyandu_id,category,status_mutasi'])
            ->whereHas('patient', function ($q) {
                $q->where('category', 'lansia')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->select([
                'id', 'patient_id', 'visit_date',
                'weight', 'height', 'waist_circumference',
                'systolic_bp', 'diastolic_bp', 'blood_sugar', 'cholesterol', 'uric_acid',
                'eye_test', 'ear_test',
                'puma_screening', 'tbc_screening_status', 'mental_screening', 'contraception',
            ])
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        return $this->cachedRecords;
    }

    /**
     * Load lansia patients ONCE for age categories.
     */
    private function getLansiaPatients()
    {
        if ($this->cachedPatients !== null) {
            return $this->cachedPatients;
        }

        $this->cachedPatients = $this->applyPosyanduScope(Patient::query(), $this->selectedPosyandu)
            ->where('category', 'lansia')
            ->where('status_mutasi', 'aktif')
            ->select(['id', 'birth_date'])
            ->get();

        return $this->cachedPatients;
    }

    /**
     * Compute all lansia analytics in a single pass over the cached records.
     * Returns a consolidated array with all metrics.
     */
    private function computeAllStats(): array
    {
        $records = $this->getLatestRecords();
        $patients = $this->getLansiaPatients();

        // ── AL-01: Kategori Umur (from patients table) ──
        $pra = 0;
        $lansia = 0;
        $resti = 0;
        foreach ($patients as $p) {
            if ($p->birth_date) {
                $age = $p->birth_date->age;
                if ($age >= 45 && $age <= 59) {
                    $pra++;
                } elseif ($age >= 60 && $age <= 69) {
                    $lansia++;
                } elseif ($age >= 70) {
                    $resti++;
                }
            }
        }

        // ── Single pass over records for ALL metrics ──
        $imtKurang = 0;
        $imtNormal = 0;
        $imtLebih = 0;
        $imtObesitas = 0;
        $hipertensi = 0;
        $gula = 0;
        $kolesterol = 0;
        $asamUrat = 0;
        $totalWaist = 0;
        $countWaist = 0;
        $obesitySentral = 0;
        $eyeIssue = 0;
        $earIssue = 0;
        $pumaCount = 0;
        $tbcCount = 0;
        $mentalCount = 0;
        $contraceptionCount = 0;

        $totalValidLansia = $records->count();

        foreach ($records as $r) {
            // AL-02: IMT
            $w = (float) $r->weight;
            $h = (float) $r->height;
            if ($w > 0 && $h > 0) {
                $imt = $w / (($h / 100) ** 2);
                if ($imt < 18.5) {
                    $imtKurang++;
                } elseif ($imt < 25) {
                    $imtNormal++;
                } elseif ($imt < 27) {
                    $imtLebih++;
                } else {
                    $imtObesitas++;
                }
            }

            // AL-03 to AL-06: Metabolic Risks
            if ($r->systolic_bp >= 140 || $r->diastolic_bp >= 90) {
                $hipertensi++;
            }
            if ($r->blood_sugar >= 200) {
                $gula++;
            }
            if ($r->cholesterol >= 200) {
                $kolesterol++;
            }
            if ($r->uric_acid >= 7.0) {
                $asamUrat++;
            }

            // AL-07: Obesitas Sentral & Gangguan Indra
            $gender = $r->patient?->gender ?? '';
            $wc = $r->waist_circumference ? (float) $r->waist_circumference : 0;
            if ($wc > 0) {
                $totalWaist += $wc;
                $countWaist++;
                if (($gender === 'L' && $wc > 90) || ($gender === 'P' && $wc > 80)) {
                    $obesitySentral++;
                }
            }

            $eye = strtolower(trim($r->eye_test ?? ''));
            if ($eye !== '' && $eye !== '-' && $eye !== 'normal') {
                $eyeIssue++;
            }

            $ear = strtolower(trim($r->ear_test ?? ''));
            if ($ear !== '' && $ear !== '-' && $ear !== 'normal') {
                $earIssue++;
            }

            // AL-08: Skrining Khusus
            $pumaVal = strtolower(trim($r->puma_screening ?? ''));
            if ($pumaVal === 'ya' || $pumaVal === '1' || $pumaVal === 'true' || $pumaVal === 'sudah') {
                $pumaCount++;
            }
            $tbcVal = strtolower(trim($r->tbc_screening_status ?? ''));
            if ($tbcVal === 'ya' || $tbcVal === '1' || $tbcVal === 'true' || $tbcVal === 'sudah' || $tbcVal === 'gejala terindikasi') {
                $tbcCount++;
            }
            $mentalVal = strtolower(trim($r->mental_screening ?? ''));
            if ($mentalVal === 'ya' || $mentalVal === '1' || $mentalVal === 'true' || $mentalVal === 'sudah' || $mentalVal === 'ada masalah') {
                $mentalCount++;
            }
            $kbVal = strtolower(trim($r->contraception ?? ''));
            if ($kbVal === 'ya' || $kbVal === '1' || $kbVal === 'true' || $kbVal === 'sudah' || $kbVal === 'aktif') {
                $contraceptionCount++;
            }
        }

        // Computed percentages
        $avgWaist = $countWaist > 0 ? round($totalWaist / $countWaist, 1) : 0;
        $obesityPct = $totalValidLansia > 0 ? round(($obesitySentral / $totalValidLansia) * 100) : 0;
        $eyePct = $totalValidLansia > 0 ? round(($eyeIssue / $totalValidLansia) * 100) : 0;
        $earPct = $totalValidLansia > 0 ? round(($earIssue / $totalValidLansia) * 100) : 0;
        $pumaPct = $totalValidLansia > 0 ? round(($pumaCount / $totalValidLansia) * 100) : 0;
        $tbcPct = $totalValidLansia > 0 ? round(($tbcCount / $totalValidLansia) * 100) : 0;
        $mentalPct = $totalValidLansia > 0 ? round(($mentalCount / $totalValidLansia) * 100) : 0;
        $contraceptionPct = $totalValidLansia > 0 ? round(($contraceptionCount / $totalValidLansia) * 100) : 0;

        // Referrals — separate lightweight query (only fetches 3 rows)
        $referrals = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->with(['patient.posyandu'])
            ->whereHas('patient', function ($q) {
                $q->where('category', 'lansia')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->whereNotNull('referral_type')
            ->where('referral_type', '!=', 'None')
            ->where('referral_type', '!=', '-')
            ->where('referral_type', '!=', '')
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get()
            ->map(fn ($r) => [
                'name' => $r->patient?->full_name ?? '-',
                'date' => $r->visit_date?->format('d/m/Y') ?? '-',
                'reason' => $r->complaint ?: ($r->diagnosis ?: ($r->referral_type ?: 'Rujukan Medis')),
                'posyandu' => $r->patient?->posyandu?->name ?? '-',
            ]);

        return [
            'ageCategories' => ['pra' => $pra, 'lansia' => $lansia, 'resti' => $resti],
            'imtStats' => ['kurang' => $imtKurang, 'normal' => $imtNormal, 'lebih' => $imtLebih, 'obesitas' => $imtObesitas],
            'metabolicRisks' => ['hipertensi' => $hipertensi, 'gula' => $gula, 'kolesterol' => $kolesterol, 'asamUrat' => $asamUrat],
            'sensoryObesityStats' => [
                'avgWaist' => $avgWaist, 'obesitySentral' => $obesitySentral, 'obesityPct' => $obesityPct,
                'eyeIssue' => $eyeIssue, 'eyePct' => $eyePct, 'earIssue' => $earIssue, 'earPct' => $earPct,
                'total' => $totalValidLansia,
            ],
            'specialScreeningReferralStats' => [
                'pumaCount' => $pumaCount, 'pumaPct' => $pumaPct,
                'tbcCount' => $tbcCount, 'tbcPct' => $tbcPct,
                'mentalCount' => $mentalCount, 'mentalPct' => $mentalPct,
                'contraceptionCount' => $contraceptionCount, 'contraceptionPct' => $contraceptionPct,
                'referrals' => $referrals, 'total' => $totalValidLansia,
            ],
        ];
    }

    public function render()
    {
        $stats = $this->computeAllStats();

        $this->ageCategories = $stats['ageCategories'];
        $this->imtStats = $stats['imtStats'];
        $this->metabolicRisks = $stats['metabolicRisks'];
        $this->sensoryObesityStats = $stats['sensoryObesityStats'];
        $this->specialScreeningReferralStats = $stats['specialScreeningReferralStats'];

        return view('livewire.admin.analytics.lansia-analytics', [
            'ageCategories' => $stats['ageCategories'],
            'imtStats' => $stats['imtStats'],
            'metabolicRisks' => $stats['metabolicRisks'],
            'sensoryObesityStats' => $stats['sensoryObesityStats'],
            'specialScreeningReferralStats' => $stats['specialScreeningReferralStats'],
        ]);
    }
}

