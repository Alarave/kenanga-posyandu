<?php

namespace App\Livewire\Misc;

use Livewire\Component;

class ErrorPage extends Component
{
    public $errorMessage;

    public function mount($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function render()
    {
        return view('livewire.misc.error-page');
    }
}
