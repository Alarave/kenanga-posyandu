<?php

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Pedukuhan;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('superadmin can access admin analytics page and see component', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);

    $this->actingAs($superadmin);
    $response = $this->get('/admin/analytics');

    $response->assertStatus(200);
    $response->assertSeeLivewire('admin.analytics');
});

test('analytics component can switch tabs and retrieve correct clinical risk rates', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    // Create a pregnancy medical record with high BP (hypertension risk)
    $pregPatient = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $pregPatient->id,
        'systolic_bp' => 145,
        'diastolic_bp' => 95,
        'pill_fe' => 1,
        'visit_date' => now(),
    ]);

    // Create an elderly medical record with metabolic risk
    $lansiaPatient = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'lansia',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $lansiaPatient->id,
        'systolic_bp' => 150,
        'diastolic_bp' => 90,
        'blood_sugar' => 220,
        'cholesterol' => 210,
        'uric_acid' => 8.2,
        'visit_date' => now(),
    ]);

    $this->actingAs($admin);

    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->assertSet('activeTab', 'overview')
        ->set('activeTab', 'pregnancy')
        ->assertSet('activeTab', 'pregnancy')
        ->assertSet('hypertensionRiskRate', 100.0)
        ->assertSet('feComplianceRate', 100.0)
        ->set('activeTab', 'lansia')
        ->assertSet('activeTab', 'lansia')
        ->assertSet('lansiaHypertensionRate', 100.0)
        ->assertSet('lansiaHyperglycemiaRate', 100.0)
        ->assertSet('lansiaHypercholesterolemiaRate', 100.0)
        ->assertSet('lansiaHyperuricemiaRate', 100.0);
});

test('analytics component can drill down on specific nutrition status and display filtered child list', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    // Create two balita patients
    $balita1 = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'balita',
        'full_name' => 'Anak Gizi Baik',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $balita1->id,
        'nutrition_status' => 'Gizi Baik',
        'visit_date' => now(),
    ]);

    $balita2 = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'balita',
        'full_name' => 'Anak Gizi Kurang',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $balita2->id,
        'nutrition_status' => 'Gizi Kurang',
        'visit_date' => now(),
    ]);

    $this->actingAs($admin);

    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Balita (Gizi Baik)', 'nutrition_status', null, 'Gizi Baik')
        ->assertSet('showDrillDown', true)
        ->assertSet('drillDownTitle', 'Detail: Balita (Gizi Baik)')
        ->assertSee('Anak Gizi Baik')
        ->assertDontSee('Anak Gizi Kurang');
});

test('analytics component can drill down on lansia age group and imt stats', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    // Create a 65 year old active registered lansia
    $lansia1 = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'lansia',
        'status_mutasi' => 'aktif',
        'full_name' => 'Mbah Sugeng 65',
        'birth_date' => now()->subYears(65),
    ]);

    // Create a 75 year old active registered lansia
    $lansia2 = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'lansia',
        'status_mutasi' => 'aktif',
        'full_name' => 'Mbah Ngatiman 75',
        'birth_date' => now()->subYears(75),
    ]);

    // Create weight/height for lansia1 to make normal IMT (50kg / 1.6m = 19.53 normal)
    MedicalRecord::factory()->create([
        'patient_id' => $lansia1->id,
        'visit_date' => now(),
        'weight' => 50.0,
        'height' => 160.0,
    ]);

    // Create weight/height for lansia2 to make obese IMT (90kg / 1.6m = 35.15 obese)
    MedicalRecord::factory()->create([
        'patient_id' => $lansia2->id,
        'visit_date' => now(),
        'weight' => 90.0,
        'height' => 160.0,
    ]);

    $this->actingAs($admin);

    // Test age group drill down
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Lansia 60-69', 'lansia_age_lansia')
        ->assertSee('Mbah Sugeng 65')
        ->assertDontSee('Mbah Ngatiman 75');

    // Test IMT group drill down
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'IMT Obesitas', 'lansia_imt_obesitas')
        ->assertSee('Mbah Ngatiman 75')
        ->assertDontSee('Mbah Sugeng 65');
});

test('analytics component can drill down on lansia metabolic risks', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    $lansia1 = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'lansia',
        'status_mutasi' => 'aktif',
        'full_name' => 'Mbah Sugeng Hipertensi',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $lansia1->id,
        'visit_date' => now(),
        'systolic_bp' => 145,
        'diastolic_bp' => 95,
    ]);

    $lansia2 = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'lansia',
        'status_mutasi' => 'aktif',
        'full_name' => 'Mbah Ngatiman Hiperglikemia',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $lansia2->id,
        'visit_date' => now(),
        'blood_sugar' => 250,
    ]);

    $this->actingAs($admin);

    // Test Hipertensi drill down
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Lansia - Hipertensi', 'lansia_hipertensi', now()->month)
        ->assertSee('Mbah Sugeng Hipertensi')
        ->assertDontSee('Mbah Ngatiman Hiperglikemia')
        ->assertSee('TD: 145/95 mmHg');

    // Test Hiperglikemia drill down
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Lansia - Hiperglikemia', 'lansia_hiperglikemia', now()->month)
        ->assertSee('Mbah Ngatiman Hiperglikemia')
        ->assertDontSee('Mbah Sugeng Hipertensi')
        ->assertSee('GDS: 250 mg/dL');
});

test('analytics component can drill down on all categories (yearly/YoY mode fallback) and support custom year parameter', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    // Create a Balita and a Lansia patient with records in July 2025 (previous year)
    $balita = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'balita',
        'full_name' => 'Balita Tahun Lalu',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $balita->id,
        'visit_date' => '2025-07-15',
        'nutrition_status' => 'Gizi Baik',
    ]);

    $lansia = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'lansia',
        'full_name' => 'Lansia Tahun Lalu',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $lansia->id,
        'visit_date' => '2025-07-15',
    ]);

    $this->actingAs($admin);

    // Call drillDown for all categories ('all') for July 2025 (month 7, year 2025)
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Semua Kunjungan - Jul', 'all', 7, null, 2025)
        ->assertSee('Balita Tahun Lalu')
        ->assertSee('Lansia Tahun Lalu')
        ->assertSee('Gizi Baik')
        ->assertSee('Lansia');
});

