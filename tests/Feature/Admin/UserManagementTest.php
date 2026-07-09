<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Admin\Management\UserManagement;

uses(RefreshDatabase::class);

test('user management counts active admins and kaders as active kaders', function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);

    $superadmin = User::factory()->create([
        'role' => 'superadmin',
        'is_active' => true,
    ]);

    // Active admin (should be counted as active kader)
    User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);

    // Active kader (should be counted as active kader)
    User::factory()->create([
        'role' => 'kader',
        'is_active' => true,
    ]);
    // Inactive kader (should NOT be counted as active kader)
    User::factory()->create([
        'role' => 'kader',
        'is_active' => false,
    ]);

    $this->actingAs($superadmin);

    $expectedCount = User::whereIn('role', ['admin', 'kader'])->where('is_active', true)->count();

    Livewire::test(UserManagement::class)
        ->assertViewHas('activeKaders', $expectedCount)
        ->assertSee('Kader Aktif');
});
