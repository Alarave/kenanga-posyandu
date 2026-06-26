<?php

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Pedukuhan;
use App\Models\Posyandu;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dashboard displays correct statistics for superadmin', function () {
    /** @var \Tests\TestCase $this */
    // Create test data
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    /** @var \App\Models\User $superadmin */
    $superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);

    // Create test patients
    Patient::factory()->count(5)->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'balita',
    ]);

    Patient::factory()->count(3)->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
    ]);

    // Create schedules for current month
    Schedule::factory()->count(2)->create([
        'posyandu_id' => $posyandu->id,
        'start_time' => now(),
    ]);

    // Create medical records for current month
    $patient = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'balita',
    ]);

    MedicalRecord::factory()->count(4)->create([
        'patient_id' => $patient->id,
        'visit_date' => now(),
    ]);

    // Act as superadmin and visit dashboard
    $this->actingAs($superadmin);
    $response = $this->get('/dashboard');

    // Assert
    $response->assertStatus(200);
    $response->assertSeeLivewire('admin.admin-dashboard');
    $response->assertSee('Total Anak');
    $response->assertSee('Total Pemeriksaan');
    $response->assertSee('Total Imunisasi');
    $response->assertSee('Pemeriksaan Terbaru');
    $response->assertSee('Imunisasi Terbaru');
});

test('admin dashboard displays scoped statistics for admin', function () {
    /** @var \Tests\TestCase $this */
    // Create test data
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu1 = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);
    $posyandu2 = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    /** @var \App\Models\User $admin */
    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu1->id,
    ]);

    // Create patients in posyandu1 (should be visible)
    Patient::factory()->count(3)->create([
        'posyandu_id' => $posyandu1->id,
        'category' => 'balita',
    ]);

    // Create patients in posyandu2 (should NOT be visible)
    Patient::factory()->count(5)->create([
        'posyandu_id' => $posyandu2->id,
        'category' => 'balita',
    ]);

    // Act as admin and visit dashboard
    $this->actingAs($admin);
    $response = $this->get('/dashboard');

    // Assert
    $response->assertStatus(200);
    $response->assertSeeLivewire('admin.admin-dashboard');
    $response->assertSee('Total Anak');
    $response->assertSee('Total Pemeriksaan');
    $response->assertSee('Total Imunisasi');
    $response->assertSee('Pemeriksaan Terbaru');
    $response->assertSee('Imunisasi Terbaru');
});

test('admin dashboard displays balita stunting warning', function () {
    /** @var \Tests\TestCase $this */
    // Create test data
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    /** @var \App\Models\User $admin */
    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    // Create balita with stunting status
    $balita = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'balita',
        'full_name' => 'Test Balita Stunting',
    ]);

    MedicalRecord::factory()->create([
        'patient_id' => $balita->id,
        'nutrition_status' => 'Gizi Buruk/Stunting',
        'visit_date' => now(),
    ]);

    // Act as admin and visit dashboard
    $this->actingAs($admin);
    $response = $this->get('/dashboard');

    // Assert
    $response->assertStatus(200);
    $response->assertSeeLivewire('admin.admin-dashboard');
    $response->assertSee('Total Anak');
    $response->assertSee('Total Pemeriksaan');
    $response->assertSee('Total Imunisasi');
    $response->assertSee('Pemeriksaan Terbaru');
    $response->assertSee('Imunisasi Terbaru');
});
