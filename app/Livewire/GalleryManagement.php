<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Gallery;

class GalleryManagement extends Component
{
    public $galleries;

    public function mount()
    {
        $this->galleries = Gallery::all();
    }

    public function render()
    {
        return view('livewire.gallery-management');
    }
}
