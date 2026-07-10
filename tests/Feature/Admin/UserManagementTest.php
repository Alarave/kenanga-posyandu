<?php

use App\Livewire\Admin\Management\UserManagement;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('user management counts active admins and kaders as active kaders', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

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

    $expectedCount = User::where('is_active', true)->count();

    Livewire::test(UserManagement::class)
        ->assertViewHas('activeKaders', $expectedCount)
        ->assertSee('Kader Aktif');
});
