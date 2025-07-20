<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;

class SearchComponent extends Component
{
    public $searchTerm = '';
    public $patients;

    public function updatedSearchTerm()
    {
        $this->patients = Patient::where('full_name', 'like', '%' . $this->searchTerm . '%')->get();
    }

    public function render()
    {
        return view('livewire.search-component');
    }
}