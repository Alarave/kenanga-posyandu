<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPassword extends Component
{
    public $email;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status == Password::RESET_LINK_SENT) {
            session()->flash('status', 'We have sent a password reset link to your email.');
            return redirect()->route('login');
        }

        session()->flash('error', 'Failed to send reset link.');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
