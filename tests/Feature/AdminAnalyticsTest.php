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

test('analytics component can drill down on pregnancy risks', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    $pregnant1 = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
        'status_mutasi' => 'aktif',
        'full_name' => 'Ibu Hamil Anemia',
        'birth_date' => now()->subYears(28),
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $pregnant1->id,
        'visit_date' => now(),
        'hemoglobin' => 10.0, // Anemia
        'height' => 160,
    ]);

    $pregnant2 = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
        'status_mutasi' => 'aktif',
        'full_name' => 'Ibu Hamil Tinggi Badan Kurang',
        'birth_date' => now()->subYears(28),
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $pregnant2->id,
        'visit_date' => now(),
        'height' => 140, // High risk height
    ]);

    $pregnant3 = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
        'status_mutasi' => 'aktif',
        'full_name' => 'Ibu Hamil Menerima Fe',
        'birth_date' => now()->subYears(28),
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $pregnant3->id,
        'visit_date' => now(),
        'nakes_gives_fe_mms' => 1,
        'height' => 160,
    ]);

    $this->actingAs($admin);

    // Test Anemia drill down
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Ibu Hamil - Kasus Anemia', 'pregnancy_anemia', now()->month)
        ->assertSee('Ibu Hamil Anemia')
        ->assertDontSee('Ibu Hamil Tinggi Badan Kurang')
        ->assertSee('Hb: 10 g/dL');

    // Test High Risk drill down
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Ibu Hamil - Risiko Tinggi & 4T', 'pregnancy_high_risk', now()->month)
        ->assertSee('Ibu Hamil Tinggi Badan Kurang')
        ->assertDontSee('Ibu Hamil Anemia')
        ->assertSee('TB: 140.00 cm');

    // Test Tablet Fe drill down
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Ibu Hamil - Pemberian Tablet Fe', 'pregnancy_tablet_fe', now()->month)
        ->assertSee('Ibu Hamil Menerima Fe')
        ->assertSee('Tablet Fe: Menerima');

    // Test ANC K1 drill down
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Ibu Hamil - Kunjungan K1', 'pregnancy_k1', now()->month)
        ->assertSee('Ibu Hamil Anemia')
        ->assertSee('Ibu Hamil Tinggi Badan Kurang')
        ->assertSee('Ibu Hamil Menerima Fe')
        ->assertSee('Total Kunjungan: 1 Kali');

    // Test ANC K2 drill down
    Livewire::test(\App\Livewire\Admin\Analytics::class)
        ->call('drillDown', 'Ibu Hamil - Kunjungan K2', 'pregnancy_k2', now()->month)
        ->assertDontSee('Ibu Hamil Anemia')
        ->assertDontSee('Ibu Hamil Tinggi Badan Kurang');
});

test('ibu hamil analytics component computes correct health scorecards and coverage metrics', function () {
    $pedukuhan = \App\Models\Pedukuhan::factory()->create();
    $posyandu = \App\Models\Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = \App\Models\User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    // Patient 1: High risk (Age 18), Hb normal (12), Fe received (1)
    $p1 = \App\Models\Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
        'status_mutasi' => 'aktif',
        'birth_date' => now()->subYears(18),
    ]);
    \App\Models\MedicalRecord::factory()->create([
        'patient_id' => $p1->id,
        'visit_date' => now(),
        'hemoglobin' => 12,
        'nakes_gives_fe_mms' => 1,
        'height' => 150,
    ]);

    // Patient 2: Normal risk (Age 25), Hb anemia (10), Fe not received (0)
    $p2 = \App\Models\Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
        'status_mutasi' => 'aktif',
        'birth_date' => now()->subYears(25),
    ]);
    \App\Models\MedicalRecord::factory()->create([
        'patient_id' => $p2->id,
        'visit_date' => now(),
        'hemoglobin' => 10,
        'nakes_gives_fe_mms' => 0,
        'height' => 150,
    ]);

    $this->actingAs($admin);

    Livewire::test(\App\Livewire\Admin\Analytics\IbuHamilAnalytics::class, [
        'selectedYear' => now()->year,
        'selectedMonth' => now()->month,
        'selectedPosyandu' => $posyandu->id
    ])
    ->assertSeeHtml('Risiko Rendah')
    ->assertSeeHtml('Hemoglobin Sehat')
    ->assertSeeHtml('Cakupan TTD')
    ->assertSeeHtml('50%'); // 1 out of 2 received Fe (50% coverage)
});




