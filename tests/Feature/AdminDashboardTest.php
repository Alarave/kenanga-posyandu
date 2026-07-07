<?php

use App\Livewire\Admin\AdminDashboard;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Pedukuhan;
use App\Models\Posyandu;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

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

test('admin dashboard displays bumil trimester and lansia names', function () {
    /** @var \Tests\TestCase $this */
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    /** @var \App\Models\User $admin */
    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    // Create a pregnant woman
    $bumil = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
        'full_name' => 'Siti Aminah Ibu Hamil',
    ]);

    // Create medical record with gestational age
    MedicalRecord::factory()->create([
        'patient_id' => $bumil->id,
        'gestational_age' => '12 minggu', // Trimester 1
        'visit_date' => now(),
    ]);

    // Create an elderly citizen (lansia)
    $lansia = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'lansia',
        'full_name' => 'Mbah Karto Lansia',
        'birth_date' => now()->subYears(65), // 65 years old
    ]);

    // Act as admin and visit dashboard
    $this->actingAs($admin);
    $response = $this->get('/dashboard');

    // Assert
    $response->assertStatus(200);
    $response->assertSeeLivewire('admin.admin-dashboard');
    $response->assertSee('Siti Aminah Ibu Hamil');
    $response->assertSee('12 minggu');
    $response->assertSee('Mbah Karto Lansia');
    $response->assertSee('65 thn');
});

test('admin dashboard allows selecting nutrition status and viewing balita list', function () {
    /** @var \Tests\TestCase $this */
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    $balita = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'balita',
        'full_name' => 'Budi Santoso Balita',
    ]);

    MedicalRecord::factory()->create([
        'patient_id' => $balita->id,
        'nutrition_status' => 'Gizi Baik',
        'visit_date' => now(),
        'weight' => 12.5,
        'height' => 85.0,
    ]);

    $this->actingAs($admin);

    Livewire::test(AdminDashboard::class)
        ->call('selectNutritionStatus', 'Gizi Baik')
        ->assertSet('showNutritionModal', true)
        ->assertSet('selectedNutritionStatus', 'Gizi Baik')
        ->assertSee('Budi Santoso Balita')
        ->assertSee('12.50 kg')
        ->assertSee('85.00 cm');
});
