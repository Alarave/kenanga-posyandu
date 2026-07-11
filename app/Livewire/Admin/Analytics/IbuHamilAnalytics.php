<?php

namespace App\Livewire\Admin\Analytics;

use App\Livewire\Traits\HasPosyanduScope;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class IbuHamilAnalytics extends Component
{
    use HasPosyanduScope;

    #[Reactive]
    public $selectedYear;

    #[Reactive]
    public $selectedMonth;

    #[Reactive]
    public $selectedPosyandu;

    public $search = '';

    #[Computed]
    public function trimesterStats()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        foreach ($records as $record) {
            $weeks = (int) filter_var($record->gestational_age, FILTER_SANITIZE_NUMBER_INT);
            if ($weeks > 0 && $weeks <= 13) {
                $t1++;
            } elseif ($weeks > 13 && $weeks <= 27) {
                $t2++;
            } elseif ($weeks > 27) {
                $t3++;
            }
        }

        return ['T1' => $t1, 'T2' => $t2, 'T3' => $t3];
    }

    #[Computed]
    public function rataRataUsiaKehamilan()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $totalWeeks = 0;
        $validCount = 0;
        foreach ($records as $record) {
            $weeks = (int) filter_var($record->gestational_age, FILTER_SANITIZE_NUMBER_INT);
            if ($weeks > 0) {
                $totalWeeks += $weeks;
                $validCount++;
            }
        }

        return $validCount > 0 ? round($totalWeeks / $validCount, 1) : 0;
    }

    // AH-02 & AH-03: HPL & Risiko 4T
    #[Computed]
    public function riskStats()
    {
        $patients = $this->applyPosyanduScope(Patient::query(), $this->selectedPosyandu)
            ->where('category', 'ibu_hamil')
            ->where('status_mutasi', 'aktif')
            ->whereHas('medicalRecords', function ($query) {
                $query->whereYear('visit_date', $this->selectedYear)
                    ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth));
            })
            ->with(['medicalRecords' => function ($query) {
                $query->whereYear('visit_date', $this->selectedYear)
                    ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth));
            }])
            ->get();
        $highRisk = 0;
        $normal = 0;

        foreach ($patients as $p) {
            $isHighRisk = false;
            if ($p->birth_date) {
                $age = $p->birth_date->age;
                if ($age < 20 || $age > 35) {
                    $isHighRisk = true;
                }
            }

            $latestRecord = $p->medicalRecords->sortByDesc('visit_date')->first();
            if ($latestRecord && $latestRecord->height && $latestRecord->height < 145) {
                $isHighRisk = true;
            }

            if ($isHighRisk) {
                $highRisk++;
            } else {
                $normal++;
            }
        }

        return ['highRisk' => $highRisk, 'normal' => $normal];
    }

    // AH-06: Hipertensi
    #[Computed]
    public function hypertensionStats()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $totalWithBp = $records->filter(function($r) {
            return $r->systolic_bp > 0 || $r->diastolic_bp > 0;
        })->count();

        $hypertension = $records->filter(function($r) {
            return ($r->systolic_bp >= 140 || $r->diastolic_bp >= 90);
        })->count();

        $normal = $totalWithBp - $hypertension;

        return [
            'hypertension' => $hypertension,
            'normal' => $normal,
            'total' => $totalWithBp,
        ];
    }

    // AH-04: TTD Status
    #[Computed]
    public function ttdStats()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $received = $records->filter(function($r) {
            return in_array(strtolower(trim($r->nakes_gives_fe_mms)), ['ya', '1', 'true']);
        })->count();
        $notReceived = $records->count() - $received;

        return ['received' => $received, 'notReceived' => $notReceived];
    }

    // AH-05: K1-K6 Kunjungan
    #[Computed]
    public function ancStats()
    {
        $patients = $this->applyPosyanduScope(Patient::query(), $this->selectedPosyandu)
            ->where('category', 'ibu_hamil')
            ->where('status_mutasi', 'aktif')
            ->whereHas('medicalRecords', function ($query) {
                $query->whereYear('visit_date', $this->selectedYear)
                    ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth));
            })
            ->with(['medicalRecords' => function ($query) {
                $query->whereYear('visit_date', $this->selectedYear)
                    ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth));
            }])
            ->get();

        $k1 = 0;
        $k2 = 0;
        $k3 = 0;
        $k4 = 0;
        $k5 = 0;
        $k6 = 0;

        foreach ($patients as $p) {
            $visitCount = $p->medicalRecords->count();
            if ($visitCount >= 1) {
                $k1++;
            }
            if ($visitCount >= 2) {
                $k2++;
            }
            if ($visitCount >= 3) {
                $k3++;
            }
            if ($visitCount >= 4) {
                $k4++;
            }
            if ($visitCount >= 5) {
                $k5++;
            }
            if ($visitCount >= 6) {
                $k6++;
            }
        }

        return ['k1' => $k1, 'k2' => $k2, 'k3' => $k3, 'k4' => $k4, 'k5' => $k5, 'k6' => $k6];
    }

    // AH-07: Kekurangan Energi Kronis (KEK) berdasarkan LILA
    #[\Livewire\Attributes\Computed]
    public function kekStats()
    {
        $records = $this->applyPosyanduScope(\App\Models\MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $totalWithLila = $records->whereNotNull('upper_arm_circumference')->where('upper_arm_circumference', '>', 0)->count();
        $kek = $records->whereNotNull('upper_arm_circumference')->where('upper_arm_circumference', '>', 0)->where('upper_arm_circumference', '<', 23.5)->count();
        $normal = $totalWithLila - $kek;

        return [
            'kek' => $kek,
            'normal' => $normal,
            'total' => $totalWithLila,
        ];
    }

    // AH-08: Skrining TBC
    #[\Livewire\Attributes\Computed]
    public function tbcStats()
    {
        $records = $this->applyPosyanduScope(\App\Models\MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $total = $records->count();

        $tbc = $records->filter(function($r) {
            return in_array(strtolower(trim($r->tbc_screening_cough ?? '')), ['ya', '1', 'true', 'sudah'])
                || in_array(strtolower(trim($r->tbc_screening_fever ?? '')), ['ya', '1', 'true', 'sudah'])
                || in_array(strtolower(trim($r->tbc_screening_weight_loss ?? '')), ['ya', '1', 'true', 'sudah'])
                || in_array(strtolower(trim($r->tbc_screening_contact ?? '')), ['ya', '1', 'true', 'sudah']);
        })->count();

        $normal = $total - $tbc;

        return [
            'tbc' => $tbc,
            'normal' => $normal,
            'total' => $total,
        ];
    }

    // Daftar Warga Ibu Hamil untuk Tabel Pemantauan Klinis
    #[\Livewire\Attributes\Computed]
    public function maternalTableData()
    {
        $patientQuery = $this->applyPosyanduScope(\App\Models\Patient::query(), $this->selectedPosyandu)
            ->where('category', 'ibu_hamil')
            ->where('status_mutasi', 'aktif')
            ->whereHas('medicalRecords', function ($query) {
                $query->whereYear('visit_date', $this->selectedYear)
                    ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth));
            })
            ->when($this->search, function ($query) {
                $query->where('full_name', 'like', '%' . $this->search . '%');
            });

        $patients = $patientQuery
            ->with(['posyandu', 'medicalRecords' => function ($query) {
                $query->whereYear('visit_date', $this->selectedYear)
                    ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
                    ->orderBy('visit_date', 'desc')
                    ->orderBy('id', 'desc');
            }])
            ->get();

        return $patients->map(function ($p) {
            $latestRecord = $p->medicalRecords->first();
            $age = $p->birth_date ? $p->birth_date->age : '-';
            
            $hpl = '-';
            $weeks = 0;
            if ($latestRecord && $latestRecord->gestational_age) {
                $weeks = (int) filter_var($latestRecord->gestational_age, FILTER_SANITIZE_NUMBER_INT);
                if ($weeks > 0 && $weeks < 40) {
                    $remainingWeeks = 40 - $weeks;
                    $hpl = \Carbon\Carbon::parse($latestRecord->visit_date)->addWeeks($remainingWeeks)->translatedFormat('d M Y');
                } elseif ($weeks >= 40) {
                    $hpl = 'Siap Melahirkan';
                }
            }

            $isHighRisk = false;
            $riskReasons = [];
            if ($p->birth_date) {
                $ageVal = $p->birth_date->age;
                if ($ageVal < 20) {
                    $isHighRisk = true;
                    $riskReasons[] = 'Usia < 20';
                } elseif ($ageVal > 35) {
                    $isHighRisk = true;
                    $riskReasons[] = 'Usia > 35';
                }
            }
            if ($latestRecord && $latestRecord->height && $latestRecord->height < 145) {
                $isHighRisk = true;
                $riskReasons[] = 'Tinggi < 145 cm';
            }

            $isKek = false;
            $lilaVal = '-';
            if ($latestRecord && $latestRecord->upper_arm_circumference) {
                $lilaVal = (float) $latestRecord->upper_arm_circumference;
                if ($lilaVal < 23.5 && $lilaVal > 0) {
                    $isKek = true;
                }
            }

            $isHypertension = false;
            $bpVal = '-';
            if ($latestRecord && ($latestRecord->systolic_bp || $latestRecord->diastolic_bp)) {
                $sys = (int) $latestRecord->systolic_bp;
                $dias = (int) $latestRecord->diastolic_bp;
                $bpVal = "{$sys}/{$dias}";
                if ($sys >= 140 || $dias >= 90) {
                    $isHypertension = true;
                }
            }

            $ancCount = $p->medicalRecords->count();

            return [
                'id' => $p->id,
                'name' => $p->full_name,
                'age' => $age,
                'gestational_age' => $weeks ? "{$weeks} minggu" : '-',
                'hpl' => $hpl,
                'lila' => $lilaVal,
                'is_kek' => $isKek,
                'bp' => $bpVal,
                'is_hypertension' => $isHypertension,
                'anc_count' => $ancCount,
                'is_high_risk' => $isHighRisk,
                'risk_reasons' => implode(', ', $riskReasons),
                'posyandu_name' => $p->posyandu?->name ?? '-',
                'ttd_received' => $latestRecord ? ($latestRecord->nakes_gives_fe_mms ? 'Ya' : 'Tidak') : '-',
            ];
        });
    }

    // AH-09: Pemantauan Berat Badan & IMT
    #[\Livewire\Attributes\Computed]
    public function weightBmiStats()
    {
        $records = $this->applyPosyanduScope(\App\Models\MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        $totalWithWeightGain = 0;
        $totalGain = 0;
        $imtDistribution = [
            'Normal' => 0,
            'Kurus' => 0,
            'Gemuk' => 0,
            'Obesitas' => 0,
            'Lainnya' => 0,
        ];

        $totalStartingWeight = 0;
        $totalCurrentWeight = 0;
        $countStarting = 0;
        $countCurrent = 0;

        foreach ($records as $r) {
            $sw = $r->starting_weight ? (float) $r->starting_weight : 0;
            $cw = $r->weight ? (float) $r->weight : 0;
            $sh = $r->starting_height ? (float) $r->starting_height : 0;

            if ($sw > 0) {
                $totalStartingWeight += $sw;
                $countStarting++;
            }
            if ($cw > 0) {
                $totalCurrentWeight += $cw;
                $countCurrent++;
            }

            if ($sw > 0 && $cw > 0 && $cw >= $sw) {
                $totalGain += ($cw - $sw);
                $totalWithWeightGain++;
            }

            $cat = null;
            if ($sw > 0 && $sh > 0) {
                $shM = $sh / 100;
                $imtVal = $sw / ($shM * $shM);
                if ($imtVal < 18.5) $cat = 'Kurus';
                elseif ($imtVal >= 18.5 && $imtVal < 25.0) $cat = 'Normal';
                elseif ($imtVal >= 25.0 && $imtVal < 30.0) $cat = 'Gemuk';
                else $cat = 'Obesitas';
            } else {
                $imt = trim($r->imt_plotting_status ?? '');
                if ($imt !== '') {
                    if (stripos($imt, 'normal') !== false) {
                        $cat = 'Normal';
                    } elseif (stripos($imt, 'kurus') !== false || stripos($imt, 'rendah') !== false) {
                        $cat = 'Kurus';
                    } elseif (stripos($imt, 'gemuk') !== false || stripos($imt, 'lebih') !== false) {
                        $cat = 'Gemuk';
                    } elseif (stripos($imt, 'obes') !== false) {
                        $cat = 'Obesitas';
                    } else {
                        $cat = 'Lainnya';
                    }
                }
            }

            if ($cat) {
                $imtDistribution[$cat]++;
            }
        }

        $avgStarting = $countStarting > 0 ? round($totalStartingWeight / $countStarting, 1) : 0;
        $avgCurrent = $countCurrent > 0 ? round($totalCurrentWeight / $countCurrent, 1) : 0;
        $avgGain = $totalWithWeightGain > 0 ? round($totalGain / $totalWithWeightGain, 1) : 0;

        return [
            'avgStarting' => $avgStarting,
            'avgCurrent' => $avgCurrent,
            'avgGain' => $avgGain,
            'imtDistribution' => $imtDistribution,
            'totalWithWeightGain' => $totalWithWeightGain,
        ];
    }

    // AH-10: Penyuluhan & Rujukan
    #[\Livewire\Attributes\Computed]
    public function counselingReferralStats()
    {
        $records = $this->applyPosyanduScope(\App\Models\MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // 1. Class participation
        $uniqueClassRecords = $records->unique('patient_id');
        $totalClassPatients = $uniqueClassRecords->count();
        $joinedClass = $uniqueClassRecords->filter(function($r) {
            return in_array(strtolower(trim($r->joins_pregnant_class ?? '')), ['ya', '1', 'true', 'sudah']);
        })->count();

        // 2. Counseling topics count
        $topics = [];
        foreach ($records as $r) {
            $topic = trim($r->counseling_topic ?? '');
            if ($topic !== '' && strtolower($topic) !== 'tidak ada' && strtolower($topic) !== '-') {
                $topics[$topic] = ($topics[$topic] ?? 0) + 1;
            }
        }
        arsort($topics);
        $topTopics = array_slice($topics, 0, 4, true);

        // 3. Referral logs
        $referrals = $records->filter(function($r) {
            return !empty(trim($r->anc_referral ?? '')) && strtolower(trim($r->anc_referral ?? '')) !== 'tidak ada' && strtolower(trim($r->anc_referral ?? '')) !== '-';
        })->map(function($r) {
            return [
                'patient_name' => $r->patient?->full_name ?? '-',
                'visit_date' => $r->visit_date?->format('d/m/Y') ?? '-',
                'anc_referral' => $r->anc_referral,
            ];
        })->take(3);

        $totalReferrals = $records->filter(fn($r) => !empty(trim($r->anc_referral ?? '')) && strtolower(trim($r->anc_referral ?? '')) !== 'tidak ada' && strtolower(trim($r->anc_referral ?? '')) !== '-')->count();

        return [
            'totalClassPatients' => $totalClassPatients,
            'joinedClass' => $joinedClass,
            'classPercentage' => $totalClassPatients > 0 ? round(($joinedClass / $totalClassPatients) * 100) : 0,
            'topTopics' => $topTopics,
            'referrals' => $referrals,
            'totalReferrals' => $totalReferrals,
        ];
    }

    public function render()
    {
        return view('livewire.admin.analytics.ibu-hamil-analytics', [
            'trimesterStats' => $this->trimesterStats(),
            'rataRataUsiaKehamilan' => $this->rataRataUsiaKehamilan,
            'riskStats' => $this->riskStats(),
            'hypertensionStats' => $this->hypertensionStats(),
            'ttdStats' => $this->ttdStats(),
            'kekStats' => $this->kekStats(),
            'tbcStats' => $this->tbcStats(),
            'ancStats' => $this->ancStats(),
            'maternalTableData' => $this->maternalTableData(),
            'weightBmiStats' => $this->weightBmiStats(),
            'counselingReferralStats' => $this->counselingReferralStats(),
        ]);
    }
}
