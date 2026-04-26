<?php

namespace App\Livewire\Actions;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Komponen untuk memperbarui profil pengguna.
 * Menggunakan UserService untuk memisahkan logika bisnis dari UI.
 */
class UpdateProfile extends Component
{
    public string $name = '';
    public string $email = '';

    protected function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ];
    }

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    /**
     * Eksekusi update profil via UserService.
     */
    public function updateProfile(UserService $userService): void
    {
        $this->validate();

        $userService->updateProfile(Auth::user(), [
            'name'  => $this->name,
            'email' => $this->email,
        ]);

        $this->dispatch('profile-updated');
        session()->flash('status', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.actions.update-profile');
    }
}
