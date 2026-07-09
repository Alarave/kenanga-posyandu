<?php

namespace App\Livewire\Admin\Management;

use App\Livewire\Shared\BaseAdminComponent;
use App\Models\Posyandu;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-layout')]
class UserManagement extends BaseAdminComponent
{
    public string $search = '';

    public string $role = '';

    public string $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function render()
    {
        // Scope pengguna berdasarkan level akses (Opsional, di sini kita tampilkan semua untuk SuperAdmin/Admin)
        $query = User::with('posyandu')
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $searchTerm = '%'.strtolower($this->search).'%';
                    $sq->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                        ->orWhereRaw('LOWER(email) LIKE ?', [$searchTerm]);
                });
            })
            ->when($this->role, fn ($q) => $q->where('role', $this->role))
            ->when($this->status !== '', function ($q) {
                if ($this->status === 'active') {
                    $q->where('is_active', true);
                } elseif ($this->status === 'inactive') {
                    $q->where('is_active', false);
                }
            })
            ->latest();

        $totalUsers = User::count();
        $inactiveUsers = User::where('is_active', false)->count();
        $activeKaders = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_KADER])->where('is_active', true)->count();

        return view('livewire.admin.user-management.index', [
            'users' => $query->paginate(10),
            'totalUsers' => $totalUsers,
            'totalPosyandu' => Posyandu::count(),
            'inactiveUsers' => $inactiveUsers,
            'activeKaders' => $activeKaders,
        ]);
    }

    public function toggleRole(int $id)
    {
        $user = User::findOrFail($id);

        // Prevent toggling superadmin
        if ($user->isSuperAdmin()) {
            $this->notify('Role Superadmin tidak dapat diubah.', 'error');

            return;
        }

        $user->role = $user->role === User::ROLE_ADMIN ? User::ROLE_KADER : User::ROLE_ADMIN;
        $user->save();

        $this->notify('Role user '.$user->name.' berhasil diubah menjadi '.strtoupper($user->role).'.');
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting self
        if ($user->id === Auth::id()) {
            $this->notify('Anda tidak dapat menghapus akun Anda sendiri.', 'error');

            return;
        }

        app(UserService::class)->deleteUser($user);
        $this->notify('User berhasil dihapus.');
    }
}
