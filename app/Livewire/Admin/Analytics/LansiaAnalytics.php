<?php

namespace App\Livewire\Admin\Analytics;

use App\Livewire\Traits\HasPosyanduScope;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Livewire\Attributes\Computed;
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

    // AL-01: Kategori Umur
    #[Computed]
    public function ageCategories()
    {
        $patients = $this->applyPosyanduScope(Patient::query(), $this->selectedPosyandu)
            ->where('category', 'lansia')->where('status_mutasi', 'aktif')->get();
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

        return ['pra' => $pra, 'lansia' => $lansia, 'resti' => $resti];
    }

    // AL-02: IMT
    #[Computed]
    public function imtStats()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'lansia')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $kurang = 0;
        $normal = 0;
        $lebih = 0;
        $obesitas = 0;
        foreach ($records as $r) {
            if ($r->weight && $r->height) {
                $imt = $r->weight / (($r->height / 100) ** 2);
                if ($imt < 18.5) {
                    $kurang++;
                } elseif ($imt < 25) {
                    $normal++;
                } elseif ($imt < 27) {
                    $lebih++;
                } else {
                    $obesitas++;
                }
            }
        }

        return ['kurang' => $kurang, 'normal' => $normal, 'lebih' => $lebih, 'obesitas' => $obesitas];
    }

    // AL-03 to AL-06: Metabolic Risks
    #[Computed]
    public function metabolicRisks()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'lansia')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $hipertensi = 0;
        $gula = 0;
        $kolesterol = 0;
        $asamUrat = 0;
        foreach ($records as $r) {
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
        }

        return ['hipertensi' => $hipertensi, 'gula' => $gula, 'kolesterol' => $kolesterol, 'asamUrat' => $asamUrat];
    }

    // AL-07: Obesitas Sentral & Gangguan Indra
    #[Computed]
    public function sensoryObesityStats()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'lansia')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $totalWaist = 0;
        $countWaist = 0;
        $obesitySentral = 0;
        $eyeIssue = 0;
        $earIssue = 0;
        $totalValidLansia = $records->count();

        foreach ($records as $r) {
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
        }

        $avgWaist = $countWaist > 0 ? round($totalWaist / $countWaist, 1) : 0;
        $obesityPct = $totalValidLansia > 0 ? round(($obesitySentral / $totalValidLansia) * 100) : 0;
        $eyePct = $totalValidLansia > 0 ? round(($eyeIssue / $totalValidLansia) * 100) : 0;
        $earPct = $totalValidLansia > 0 ? round(($earIssue / $totalValidLansia) * 100) : 0;

        return [
            'avgWaist' => $avgWaist,
            'obesitySentral' => $obesitySentral,
            'obesityPct' => $obesityPct,
            'eyeIssue' => $eyeIssue,
            'eyePct' => $eyePct,
            'earIssue' => $earIssue,
            'earPct' => $earPct,
            'total' => $totalValidLansia,
        ];
    }

    // AL-08: Skrining Khusus Lansia & Rujukan
    #[Computed]
    public function specialScreeningReferralStats()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'lansia')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $pumaCount = 0;
        $tbcCount = 0;
        $mentalCount = 0;
        $contraceptionCount = 0;
        $totalValidLansia = $records->count();

        foreach ($records as $r) {
            $puma = strtolower(trim($r->puma_screening ?? ''));
            if ($puma === 'ya' || $puma === '1' || $puma === 'true' || $puma === 'sudah') {
                $pumaCount++;
            }
            $tbc = strtolower(trim($r->tbc_screening_status ?? ''));
            if ($tbc === 'ya' || $tbc === '1' || $tbc === 'true' || $tbc === 'sudah' || $tbc === 'gejala terindikasi') {
                $tbcCount++;
            }
            $mental = strtolower(trim($r->mental_screening ?? ''));
            if ($mental === 'ya' || $mental === '1' || $mental === 'true' || $mental === 'sudah' || $mental === 'ada masalah') {
                $mentalCount++;
            }
            $kb = strtolower(trim($r->contraception ?? ''));
            if ($kb === 'ya' || $kb === '1' || $kb === 'true' || $kb === 'sudah' || $kb === 'aktif') {
                $contraceptionCount++;
            }
        }

        $pumaPct = $totalValidLansia > 0 ? round(($pumaCount / $totalValidLansia) * 100) : 0;
        $tbcPct = $totalValidLansia > 0 ? round(($tbcCount / $totalValidLansia) * 100) : 0;
        $mentalPct = $totalValidLansia > 0 ? round(($mentalCount / $totalValidLansia) * 100) : 0;
        $contraceptionPct = $totalValidLansia > 0 ? round(($contraceptionCount / $totalValidLansia) * 100) : 0;

        // Recent referrals (referral_type is not null and not 'None')
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
            'pumaCount' => $pumaCount,
            'pumaPct' => $pumaPct,
            'tbcCount' => $tbcCount,
            'tbcPct' => $tbcPct,
            'mentalCount' => $mentalCount,
            'mentalPct' => $mentalPct,
            'contraceptionCount' => $contraceptionCount,
            'contraceptionPct' => $contraceptionPct,
            'referrals' => $referrals,
            'total' => $totalValidLansia,
        ];
    }

    public function render()
    {
        return view('livewire.admin.analytics.lansia-analytics', [
            'ageCategories' => $this->ageCategories(),
            'imtStats' => $this->imtStats(),
            'metabolicRisks' => $this->metabolicRisks(),
            'sensoryObesityStats' => $this->sensoryObesityStats(),
            'specialScreeningReferralStats' => $this->specialScreeningReferralStats(),
        ]);
    }
}
