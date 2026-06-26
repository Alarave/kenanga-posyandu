<?php

namespace App\Livewire\Admin\Analytics;

use Livewire\Component;
use App\Livewire\Traits\HasPosyanduScope;
use App\Models\MedicalRecord;
use App\Models\Patient;

class IbuHamilAnalytics extends Component
{
    use HasPosyanduScope;

    public $selectedYear;
    public $selectedMonth;
    public $selectedPosyandu;

    public function mount($selectedYear = null, $selectedMonth = null, $selectedPosyandu = null)
    {
        $this->selectedYear = $selectedYear ?? now()->year;
        $this->selectedMonth = $selectedMonth;
        $this->selectedPosyandu = $selectedPosyandu;
    }

    #[\Livewire\Attributes\Computed]
    public function activePatientsQuery()
    {
        return $this->applyPosyanduScope(Patient::query(), $this->selectedPosyandu)
            ->where('category', 'ibu_hamil')
            ->where('status_mutasi', 'aktif')
            ->whereHas('medicalRecords', function ($q) {
                $q->whereYear('visit_date', $this->selectedYear)
                  ->when($this->selectedMonth, fn($mq) => $mq->whereMonth('visit_date', $this->selectedMonth));
            });
    }

    #[\Livewire\Attributes\Computed]
    public function trimesterStats()
    {
        $patientIds = $this->activePatientsQuery()->pluck('id');

        $latestRecords = MedicalRecord::whereIn('patient_id', $patientIds)
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->whereIn('id', function($query) {
                $query->selectRaw('MAX(id)')->from('medical_records')->groupBy('patient_id');
            })->get();

        $t1 = 0; $t2 = 0; $t3 = 0;
        foreach ($latestRecords as $record) {
            $weeks = (int) filter_var($record->gestational_age, FILTER_SANITIZE_NUMBER_INT);
            if ($weeks > 0 && $weeks <= 13) $t1++;
            elseif ($weeks > 13 && $weeks <= 27) $t2++;
            elseif ($weeks > 27) $t3++;
        }

        return ['T1' => $t1, 'T2' => $t2, 'T3' => $t3];
    }

    #[\Livewire\Attributes\Computed]
    public function riskStats()
    {
        $patients = $this->activePatientsQuery()->get();
        $highRisk = 0;
        $normal = 0;

        foreach ($patients as $p) {
            $isHighRisk = false;
            if ($p->birth_date) {
                $age = $p->birth_date->age;
                if ($age < 20 || $age > 35) $isHighRisk = true;
            }

            $latestRecord = MedicalRecord::where('patient_id', $p->id)
                ->whereYear('visit_date', $this->selectedYear)
                ->when($this->selectedMonth, fn($q) => $q->whereMonth('visit_date', $this->selectedMonth))
                ->latest('visit_date')
                ->first();

            if ($latestRecord && $latestRecord->height && $latestRecord->height < 145) {
                $isHighRisk = true;
            }

            if ($isHighRisk) $highRisk++;
            else $normal++;
        }

        return ['highRisk' => $highRisk, 'normal' => $normal];
    }

    #[\Livewire\Attributes\Computed]
    public function anemiaStats()
    {
        return $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', fn($q) => $q->where('category', 'ibu_hamil'))
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->whereNotNull('hemoglobin')
            ->where('hemoglobin', '<', 11)
            ->count();
    }

    #[\Livewire\Attributes\Computed]
    public function ttdStats()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', fn($q) => $q->where('category', 'ibu_hamil'))
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->get();

        $received = $records->where('nakes_gives_fe_mms', 1)->count();
        $notReceived = $records->where('nakes_gives_fe_mms', 0)->count();

        return ['received' => $received, 'notReceived' => $notReceived];
    }

    #[\Livewire\Attributes\Computed]
    public function kekStats()
    {
        $patientIds = $this->activePatientsQuery()->pluck('id');

        $latestRecords = MedicalRecord::whereIn('patient_id', $patientIds)
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->whereIn('id', function($query) {
                $query->selectRaw('MAX(id)')->from('medical_records')->groupBy('patient_id');
            })->get();

        $kek = 0;
        $normal = 0;
        foreach ($latestRecords as $r) {
            if ($r->upper_arm_circumference && $r->upper_arm_circumference < 23.5) {
                $kek++;
            } else {
                $normal++;
            }
        }
        return ['kek' => $kek, 'normal' => $normal];
    }

    #[\Livewire\Attributes\Computed]
    public function ancStats()
    {
        $patients = $this->activePatientsQuery()->get();
        $k1 = 0; $k2 = 0; $k3 = 0; $k4 = 0; $k5 = 0; $k6 = 0;

        foreach ($patients as $p) {
            $visitCount = MedicalRecord::where('patient_id', $p->id)
                ->whereYear('visit_date', $this->selectedYear)
                ->when($this->selectedMonth, fn($q) => $q->whereMonth('visit_date', $this->selectedMonth))
                ->count();

            if ($visitCount >= 1) $k1++;
            if ($visitCount >= 2) $k2++;
            if ($visitCount >= 3) $k3++;
            if ($visitCount >= 4) $k4++;
            if ($visitCount >= 5) $k5++;
            if ($visitCount >= 6) $k6++;
        }

        return ['k1' => $k1, 'k2' => $k2, 'k3' => $k3, 'k4' => $k4, 'k5' => $k5, 'k6' => $k6];
    }

    public function render()
    {
        return view('livewire.admin.analytics.ibu-hamil-analytics', [
            'trimesterStats' => $this->trimesterStats(),
            'riskStats' => $this->riskStats(),
            'anemiaCount' => $this->anemiaStats(),
            'ttdStats' => $this->ttdStats(),
            'kekStats' => $this->kekStats(),
            'ancStats' => $this->ancStats()
        ]);
    }
}
