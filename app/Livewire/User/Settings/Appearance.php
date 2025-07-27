<?php

namespace App\Livewire\User\Settings;

use Livewire\Component;

class Appearance extends Component
{
    public $theme;

    public function mount()
    {
        $this->theme = session('theme', 'light');
    }

    public function changeTheme()
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';
        session(['theme' => $this->theme]);
    }

    public function render()
    {
        return view('livewire.user.settings.appearance');
    }
}
