<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;

class VerifyEmail extends Component
{
    public function verifyEmail()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        session()->flash('status', 'Your email has been verified!');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
