<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Role;
use App\Models\Permission;
use Livewire\Component;

class RolePermissionManagement extends Component
{
    public function togglePermission($roleId, $permissionId)
    {
        $role = Role::find($roleId);
        if ($role) {
            $role->permissions()->toggle($permissionId);
            session()->flash('message', 'Pengaturan hak akses untuk role ' . $role->display_name . ' berhasil diperbarui.');
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.role-permission-management', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }
}
