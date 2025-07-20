<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;

class PatientManagement extends Component
{
    public $patients;

    public function mount()
    {
        $this->patients = Patient::all();
    }

    public function render()
    {
        return view('livewire.patient-management');
    }
}
