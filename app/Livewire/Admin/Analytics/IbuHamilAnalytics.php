?php

namespace App\Livewire\Admin\Analytics;

use App\Livewire\Traits\HasPosyanduScope;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Carbon\Carbon;
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

    /**
     * Cached collections â€” loaded once, shared across all metric calculations.
     */
    private $cachedLatestRecords = null;

    private $cachedPatientsWithRecords = null;

    private $cachedAllRecords = null;

    /**
     * Load latest medical records per patient ONCE.
     * Replaces 6 duplicate queries (trimester, hypertension, TTD, KEK, TBC, weightBmi).
     */
    private function getLatestRecords()
    {
        if ($this->cachedLatestRecords !== null) {
            return $this->cachedLatestRecords;
        }

        $this->cachedLatestRecords = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->with(['patient:id,full_name,birth_date,gender,category,status_mutasi,posyandu_id'])
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->select([
                'id', 'patient_id', 'visit_date',
                'gestational_age', 'systolic_bp', 'diastolic_bp',
                'nakes_gives_fe_mms', 'upper_arm_circumference',
                'tbc_screening_cough', 'tbc_screening_fever', 'tbc_screening_weight_loss', 'tbc_screening_contact',
                'weight', 'height', 'starting_weight', 'starting_height', 'imt_plotting_status',
            ])
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('patient_id');

        return $this->cachedLatestRecords;
    }

    /**
     * Load patients with medical records ONCE.
     * Replaces 2 duplicate queries (riskStats, ancStats).
     */
    private function getPatientsWithRecords()
    {
        if ($this->cachedPatientsWithRecords !== null) {
            return $this->cachedPatientsWithRecords;
        }

        $this->cachedPatientsWithRecords = $this->applyPosyanduScope(Patient::query(), $this->selectedPosyandu)
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

        return $this->cachedPatientsWithRecords;
    }

    /**
     * Load ALL records (not unique per patient) ONCE.
     * Used by counselingReferralStats which needs all records, not just latest.
     */
    private function getAllRecords()
    {
        if ($this->cachedAllRecords !== null) {
            return $this->cachedAllRecords;
        }

        $this->cachedAllRecords = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->with(['patient:id,full_name,category,status_mutasi'])
            ->whereHas('patient', function ($q) {
                $q->where('category', 'ibu_hamil')->where('status_mutasi', 'aktif');
            })
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return $this->cachedAllRecords;
    }

    /**
     * Compute record-based stats in a SINGLE pass over cached latest records.
     * Covers: trimester, rata-rata usia kehamilan, hypertension, TTD, KEK, TBC, weight/BMI.
     */
    private function computeRecordBasedStats(): array
    {
        $records = $this->getLatestRecords();

        // Trimester
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        $totalWeeks = 0;
        $validWeeksCount = 0;

        // Hypertension
        $totalWithBp = 0;
        $hypertension = 0;

        // TTD
        $ttdReceived = 0;

        // KEK
        $totalWithLila = 0;
        $kekCount = 0;

        // TBC
        $tbcCount = 0;

        // Weight/BMI
        $totalGain = 0;
        $totalWithWeightGain = 0;
        $totalStartingWeight = 0;
        $totalCurrentWeight = 0;
        $countStarting = 0;
        $countCurrent = 0;
        $imtDistribution = ['Normal' => 0, 'Kurus' => 0, 'Gemuk' => 0, 'Obesitas' => 0, 'Lainnya' => 0];

        $totalRecords = $records->count();

        foreach ($records as $r) {
            // â”€â”€ Trimester â”€â”€
            $weeks = (int) filter_var($r->gestational_age, FILTER_SANITIZE_NUMBER_INT);
            if ($weeks > 0) {
                $totalWeeks += $weeks;
                $validWeeksCount++;
                if ($weeks <= 13) {
                    $t1++;
                } elseif ($weeks <= 27) {
                    $t2++;
                } else {
                    $t3++;
                }
            }

            // â”€â”€ Hypertension â”€â”€
            if ($r->systolic_bp > 0 || $r->diastolic_bp > 0) {
                $totalWithBp++;
                if ($r->systolic_bp >= 140 || $r->diastolic_bp >= 90) {
                    $hypertension++;
                }
            }

            // â”€â”€ TTD â”€â”€
            if (in_array(strtolower(trim($r->nakes_gives_fe_mms)), ['ya', '1', 'true'])) {
                $ttdReceived++;
            }

            // â”€â”€ KEK â”€â”€
            $lila = $r->upper_arm_circumference ? (float) $r->upper_arm_circumference : 0;
            if ($lila > 0) {
                $totalWithLila++;
                if ($lila < 23.5) {
                    $kekCount++;
                }
            }

            // â”€â”€ TBC â”€â”€
            if (
                in_array(strtolower(trim($r->tbc_screening_cough ?? '')), ['ya', '1', 'true', 'sudah']) ||
                in_array(strtolower(trim($r->tbc_screening_fever ?? '')), ['ya', '1', 'true', 'sudah']) ||
                in_array(strtolower(trim($r->tbc_screening_weight_loss ?? '')), ['ya', '1', 'true', 'sudah']) ||
                in_array(strtolower(trim($r->tbc_screening_contact ?? '')), ['ya', '1', 'true', 'sudah'])
            ) {
                $tbcCount++;
            }

            // â”€â”€ Weight/BMI â”€â”€
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

        return [
            'trimesterStats' => ['T1' => $t1, 'T2' => $t2, 'T3' => $t3],
            'rataRataUsiaKehamilan' => $validWeeksCount > 0 ? round($totalWeeks / $validWeeksCount, 1) : 0,
            'hypertensionStats' => [
                'hypertension' => $hypertension,
                'normal' => $totalWithBp - $hypertension,
                'total' => $totalWithBp,
            ],
            'ttdStats' => ['received' => $ttdReceived, 'notReceived' => $totalRecords - $ttdReceived],
            'kekStats' => [
                'kek' => $kekCount,
                'normal' => $totalWithLila - $kekCount,
                'total' => $totalWithLila,
            ],
            'tbcStats' => [
                'tbc' => $tbcCount,
                'normal' => $totalRecords - $tbcCount,
                'total' => $totalRecords,
            ],
            'weightBmiStats' => [
                'avgStarting' => $countStarting > 0 ? round($totalStartingWeight / $countStarting, 1) : 0,
                'avgCurrent' => $countCurrent > 0 ? round($totalCurrentWeight / $countCurrent, 1) : 0,
                'avgGain' => $totalWithWeightGain > 0 ? round($totalGain / $totalWithWeightGain, 1) : 0,
                'imtDistribution' => $imtDistribution,
                'totalWithWeightGain' => $totalWithWeightGain,
            ],
        ];
    }

    /**
     * Compute patient-based stats: risk assessment and ANC visit counts.
     */
    private function computePatientBasedStats(): array
    {
        $patients = $this->getPatientsWithRecords();

        $highRisk = 0;
        $normal = 0;
        $k1 = 0;
        $k2 = 0;
        $k3 = 0;
        $k4 = 0;
        $k5 = 0;
        $k6 = 0;

        foreach ($patients as $p) {
            // Risk stats
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

            // ANC stats
            $visitCount = $p->medicalRecords->count();
            if ($visitCount >= 1) $k1++;
            if ($visitCount >= 2) $k2++;
            if ($visitCount >= 3) $k3++;
            if ($visitCount >= 4) $k4++;
            if ($visitCount >= 5) $k5++;
            if ($visitCount >= 6) $k6++;
        }

        return [
            'riskStats' => ['highRisk' => $highRisk, 'normal' => $normal],
            'ancStats' => ['k1' => $k1, 'k2' => $k2, 'k3' => $k3, 'k4' => $k4, 'k5' => $k5, 'k6' => $k6],
        ];
    }

    /**
     * Compute counseling and referral stats from ALL records.
     */
    private function computeCounselingReferralStats(): array
    {
        $records = $this->getAllRecords();

        // 1. Class participation
        $uniqueClassRecords = $records->unique('patient_id');
        $totalClassPatients = $uniqueClassRecords->count();
        $joinedClass = $uniqueClassRecords->filter(function ($r) {
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
        $referrals = $records->filter(function ($r) {
            return ! empty(trim($r->anc_referral ?? '')) && strtolower(trim($r->anc_referral ?? '')) !== 'tidak ada' && strtolower(trim($r->anc_referral ?? '')) !== '-';
        })->map(function ($r) {
            return [
                'patient_name' => $r->patient?->full_name ?? '-',
                'visit_date' => $r->visit_date?->format('d/m/Y') ?? '-',
                'anc_referral' => $r->anc_referral,
            ];
        })->take(3);

        $totalReferrals = $records->filter(fn ($r) => ! empty(trim($r->anc_referral ?? '')) && strtolower(trim($r->anc_referral ?? '')) !== 'tidak ada' && strtolower(trim($r->anc_referral ?? '')) !== '-')->count();

        return [
            'totalClassPatients' => $totalClassPatients,
            'joinedClass' => $joinedClass,
            'classPercentage' => $totalClassPatients > 0 ? round(($joinedClass / $totalClassPatients) * 100) : 0,
            'topTopics' => $topTopics,
            'referrals' => $referrals,
            'totalReferrals' => $totalReferrals,
        ];
    }

    /**
     * Compute maternal table data from cached patient collection.
     */
    private function computeMaternalTableData()
    {
        $patientQuery = $this->applyPosyanduScope(Patient::query(), $this->selectedPosyandu)
            ->where('category', 'ibu_hamil')
            ->where('status_mutasi', 'aktif')
            ->whereHas('medicalRecords', function ($query) {
                $query->whereYear('visit_date', $this->selectedYear)
                    ->when($this->selectedMonth, fn ($q) => $q->whereMonth('visit_date', $this->selectedMonth));
            })
            ->when($this->search, function ($query) {
                $query->where('full_name', 'like', '%'.$this->search.'%');
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
                    $hpl = Carbon::parse($latestRecord->visit_date)->addWeeks($remainingWeeks)->translatedFormat('d M Y');
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

    public function render()
    {
        $recordStats = $this->computeRecordBasedStats();
        $patientStats = $this->computePatientBasedStats();

        return view('livewire.admin.analytics.ibu-hamil-analytics', [
            'trimesterStats' => $recordStats['trimesterStats'],
            'rataRataUsiaKehamilan' => $recordStats['rataRataUsiaKehamilan'],
            'riskStats' => $patientStats['riskStats'],
            'hypertensionStats' => $recordStats['hypertensionStats'],
            'ttdStats' => $recordStats['ttdStats'],
            'kekStats' => $recordStats['kekStats'],
            'tbcStats' => $recordStats['tbcStats'],
            'ancStats' => $patientStats['ancStats'],
            'maternalTableData' => $this->computeMaternalTableData(),
            'weightBmiStats' => $recordStats['weightBmiStats'],
            'counselingReferralStats' => $this->computeCounselingReferralStats(),
        ]);
    }
}
