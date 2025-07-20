<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Schedule;

class ScheduleManagement extends Component
{
    public $schedules;

    public function mount()
    {
        $this->schedules = Schedule::all();
    }

    public function render()
    {
        return view('livewire.schedule-management');
    }
}
