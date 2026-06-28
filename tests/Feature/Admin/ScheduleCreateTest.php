<?php

use App\Models\Posyandu;
use App\Models\User;
use App\Livewire\Admin\Management\ScheduleCreate;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('superadmin can create schedule', function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    $posyandu = Posyandu::factory()->create([
        'name' => 'KENANGA 1',
    ]);
    
    $superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);
    
    $this->actingAs($superadmin);
    
    Livewire::test(ScheduleCreate::class)
        ->set('title', 'Jadwal Baru')
        ->set('description', 'Deskripsi Jadwal')
        ->set('start_time', '2026-07-01T10:00')
        ->set('end_time', '2026-07-01T12:00')
        ->set('location', 'Balai RW')
        ->set('status', 'upcoming')
        ->set('posyandu_id', $posyandu->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.schedules.index'));
});

test('admin can create schedule without explicitly setting posyandu_id', function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    $posyandu = Posyandu::factory()->create([
        'name' => 'KENANGA 1',
    ]);
    
    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);
    
    $this->actingAs($admin);
    
    Livewire::test(ScheduleCreate::class)
        ->set('title', 'Jadwal Baru')
        ->set('description', 'Deskripsi Jadwal')
        ->set('start_time', '2026-07-01T10:00')
        ->set('end_time', '2026-07-01T12:00')
        ->set('location', 'Balai RW')
        ->set('status', 'upcoming')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.schedules.index'));
});
