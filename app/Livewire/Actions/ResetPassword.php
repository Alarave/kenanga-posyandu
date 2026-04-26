<?php

namespace App\Livewire\Actions;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

/**
 * Komponen untuk mereset password melalui token email.
 */
class ResetPassword extends Component
{
    public string $email = '';
    public string $token = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function mount(string $token, string $email): void
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Eksekusi reset password menggunakan Laravel Password Broker.
     */
    public function resetPassword(UserService $userService)
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function (User $user) use ($userService) {
                // Gunakan service untuk konsistensi logging
                $userService->resetPassword($user, $this->password);
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            session()->flash('status', 'Password Anda berhasil direset.');
            return redirect()->route('login');
        }

        session()->flash('error', 'Gagal mereset password. Pastikan token masih valid.');
    }

    public function render()
    {
        return view('livewire.actions.reset-password');
    }
}
