<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Komponen sederhana untuk menangani proses logout.
 */
class Logout extends Component
{
    /**
     * Menjalankan proses logout dan membersihkan session.
     */
    public function logout()
    {
        Auth::logout();
        
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.actions.logout');
    }
}
