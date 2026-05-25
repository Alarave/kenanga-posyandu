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
