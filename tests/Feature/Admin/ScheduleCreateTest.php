<?php

use App\Livewire\Admin\Management\ScheduleCreate;
use App\Models\Posyandu;
use App\Models\Schedule;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('superadmin can create schedule', function () {
    $this->seed(RolesAndPermissionsSeeder::class);
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
    $this->seed(RolesAndPermissionsSeeder::class);
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

test('superadmin can create monthly recurring schedules', function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $posyandu = Posyandu::factory()->create([
        'name' => 'KENANGA 1',
    ]);

    $superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);

    $this->actingAs($superadmin);

    Livewire::test(ScheduleCreate::class)
        ->set('title', 'Jadwal Rutin Bulanan')
        ->set('description', 'Deskripsi Rutin')
        ->set('start_time', '2026-08-10T10:00')
        ->set('end_time', '2026-08-10T12:00')
        ->set('location', 'Balai RW')
        ->set('status', 'upcoming')
        ->set('posyandu_id', $posyandu->id)
        ->set('is_recurring', true)
        ->set('repeat_months', 3)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.schedules.index'));

    $this->assertDatabaseHas('schedules', [
        'title' => 'Jadwal Rutin Bulanan',
        'start_time' => '2026-08-10 10:00:00',
    ]);

    $this->assertDatabaseHas('schedules', [
        'title' => 'Jadwal Rutin Bulanan',
        'start_time' => '2026-09-10 10:00:00',
    ]);

    $this->assertDatabaseHas('schedules', [
        'title' => 'Jadwal Rutin Bulanan',
        'start_time' => '2026-10-10 10:00:00',
    ]);

    // Assert that exactly 3 schedules were created
    $this->assertEquals(3, Schedule::count());
});
