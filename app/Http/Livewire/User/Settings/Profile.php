<?php

namespace App\Http\Livewire\User\Settings;

use Livewire\Component;
use App\Models\User;

class Profile extends Component
{
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.user.settings.profile');
    }
}
