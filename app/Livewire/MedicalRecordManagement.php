<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MedicalRecord;

class MedicalRecordManagement extends Component
{
    public $medicalRecords;

    public function mount()
    {
        $this->medicalRecords = MedicalRecord::all();
    }

    public function render()
    {
        return view('livewire.medical-record-management');
    }
}
