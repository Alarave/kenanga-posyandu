<?php

namespace App\Livewire\Admin\Analytics;

use Livewire\Component;
use App\Livewire\Traits\HasPosyanduScope;
use App\Models\MedicalRecord;
use App\Models\Patient;

class LansiaAnalytics extends Component
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
            ->where('category', 'lansia')
            ->where('status_mutasi', 'aktif')
            ->whereHas('medicalRecords', function ($q) {
                $q->whereYear('visit_date', $this->selectedYear)
                  ->when($this->selectedMonth, fn($mq) => $mq->whereMonth('visit_date', $this->selectedMonth));
            });
    }

    #[\Livewire\Attributes\Computed]
    public function ageCategories()
    {
        $patients = $this->activePatientsQuery()->get();
        $pra = 0; $lansia = 0; $resti = 0;

        foreach ($patients as $p) {
            if ($p->birth_date) {
                $age = $p->birth_date->age;
                if ($age >= 45 && $age <= 59) $pra++;
                elseif ($age >= 60 && $age <= 69) $lansia++;
                elseif ($age >= 70) $resti++;
            }
        }
        return ['pra' => $pra, 'lansia' => $lansia, 'resti' => $resti];
    }

    #[\Livewire\Attributes\Computed]
    public function imtStats()
    {
        $patientIds = $this->activePatientsQuery()->pluck('id');
        $records = MedicalRecord::whereIn('patient_id', $patientIds)
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->whereIn('id', function($query) {
                $query->selectRaw('MAX(id)')->from('medical_records')->groupBy('patient_id');
            })->get();

        $kurang = 0; $normal = 0; $lebih = 0; $obesitas = 0;
        foreach ($records as $r) {
            if ($r->weight && $r->height) {
                $imt = $r->weight / (($r->height / 100) ** 2);
                if ($imt < 18.5) $kurang++;
                elseif ($imt < 25) $normal++;
                elseif ($imt < 27) $lebih++;
                else $obesitas++;
            }
        }
        return ['kurang' => $kurang, 'normal' => $normal, 'lebih' => $lebih, 'obesitas' => $obesitas];
    }

    #[\Livewire\Attributes\Computed]
    public function metabolicRisks()
    {
        $records = $this->applyPosyanduScope(MedicalRecord::query(), $this->selectedPosyandu)
            ->whereHas('patient', fn($q) => $q->where('category', 'lansia'))
            ->whereYear('visit_date', $this->selectedYear)
            ->when($this->selectedMonth, fn($q) => $q->whereMonth('visit_date', $this->selectedMonth))
            ->get();

        $hipertensi = 0; $gula = 0; $kolesterol = 0; $asamUrat = 0;
        foreach ($records as $r) {
            if ($r->systolic_bp >= 140 || $r->diastolic_bp >= 90) $hipertensi++;
            if ($r->blood_sugar >= 200) $gula++;
            if ($r->cholesterol >= 200) $kolesterol++;
            if ($r->uric_acid >= 7.0) $asamUrat++;
        }
        return ['hipertensi' => $hipertensi, 'gula' => $gula, 'kolesterol' => $kolesterol, 'asamUrat' => $asamUrat];
    }

    #[\Livewire\Attributes\Computed]
    public function independenceStats()
    {
        $patients = $this->activePatientsQuery()->get();
        $a = 0; $b = 0; $c = 0;
        foreach ($patients as $p) {
            if ($p->independence_status == 'A') $a++;
            elseif ($p->independence_status == 'B') $b++;
            elseif ($p->independence_status == 'C') $c++;
        }
        return ['a' => $a, 'b' => $b, 'c' => $c];
    }

    public function render()
    {
        return view('livewire.admin.analytics.lansia-analytics', [
            'ageCategories' => $this->ageCategories(),
            'imtStats' => $this->imtStats(),
            'metabolicRisks' => $this->metabolicRisks(),
            'independenceStats' => $this->independenceStats()
        ]);
    }
}
