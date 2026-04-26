<?php

namespace App\Livewire\Actions;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Komponen untuk menghapus akun pengguna secara mandiri.
 */
class DeleteAccount extends Component
{
    public string $password = '';

    protected array $rules = [
        'password' => 'required|min:6',
    ];

    /**
     * Eksekusi penghapusan akun via UserService.
     */
    public function deleteAccount(UserService $userService)
    {
        $this->validate();

        // Service menangani verifikasi password dan penghapusan
        $userService->deleteAccount(Auth::user(), $this->password);

        Auth::logout();

        session()->flash('status', 'Akun Anda berhasil dihapus.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.actions.delete-account');
    }
}
