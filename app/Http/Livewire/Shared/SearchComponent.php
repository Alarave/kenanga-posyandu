<?php

namespace App\Http\Livewire\Shared;

use Livewire\Component;

class SearchComponent extends Component
{
    public $searchTerm;

    public function updatedSearchTerm()
    {
        // Perform the search logic here, like updating a list of results.
        // You can fire events or update states based on the search term.
    }

    public function render()
    {
        return view('livewire.shared.search-component');
    }
}
