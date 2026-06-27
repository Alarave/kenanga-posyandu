<?php

namespace App\Livewire\User\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfile extends Component
{
    public string $name = '';

    public string $email = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
        ];
    }

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfile()
    {
        $this->validate();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('status', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.user.profile.user-profile');
    }
}
