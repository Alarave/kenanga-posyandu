<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pedukuhan;

class PedukuhanManagement extends Component
{
    public $pedukuhans;

    public function mount()
    {
        $this->pedukuhans = Pedukuhan::all();
    }

    public function render()
    {
        return view('livewire.pedukuhan-management');
    }
}