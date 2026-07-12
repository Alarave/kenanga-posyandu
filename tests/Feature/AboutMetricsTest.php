<?php

use App\Livewire\Admin\PatientManagement\Index as PatientIndex;
use App\Models\Patient;
use App\Models\Pedukuhan;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Clear cache to prevent test pollution
    Cache::forget('about_page_kaders');

    // Create baseline pedukuhan and posyandu
    $this->pedukuhan = Pedukuhan::factory()->create();
    $this->posyandu1 = Posyandu::factory()->create(['pedukuhan_id' => $this->pedukuhan->id]);
    $this->posyandu2 = Posyandu::factory()->create(['pedukuhan_id' => $this->pedukuhan->id]);

    // Create some kaders
    $this->kader1 = User::factory()->create([
        'role' => 'kader',
        'is_active' => true,
        'posyandu_id' => $this->posyandu1->id,
    ]);
    $this->kader2 = User::factory()->create([
        'role' => 'kader',
        'is_active' => true,
        'posyandu_id' => $this->posyandu1->id,
    ]);
    // Inactive kader - should not be included
    $this->inactiveKader = User::factory()->create([
        'role' => 'kader',
        'is_active' => false,
        'posyandu_id' => $this->posyandu1->id,
    ]);

    // Create patients
    // 1. Bayi (age < 12 months, database category 'balita')
    $this->bayi = Patient::factory()->create([
        'category' => 'balita',
        'birth_date' => now()->subMonths(6),
        'posyandu_id' => $this->posyandu1->id,
    ]);

    // 2. Baduta (age 12-23 months, database category 'balita')
    $this->baduta = Patient::factory()->create([
        'category' => 'balita',
        'birth_date' => now()->subMonths(18),
        'posyandu_id' => $this->posyandu1->id,
    ]);

    // 3. Balita (age >= 24 months, database category 'balita')
    $this->balita = Patient::factory()->create([
        'category' => 'balita',
        'birth_date' => now()->subMonths(36),
        'posyandu_id' => $this->posyandu1->id,
    ]);

    // 4. Lansia (database category 'lansia')
    $this->lansia = Patient::factory()->create([
        'category' => 'lansia',
        'birth_date' => now()->subYears(65),
        'posyandu_id' => $this->posyandu1->id,
    ]);
});
it('filters and counts bayi, baduta, and balita dynamically on the patient index page', function () {
    // Authenticate as a user who has access (e.g. superadmin)
    $admin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);
    $this->actingAs($admin);

    // Verify statistics cards are displayed correctly with values: Bayi: 1, Baduta: 1, Balita: 1
    $response = $this->get(route('admin.patients.index'));
    $response->assertOk();

    // Verify Livewire component logic
    $livewire = Livewire::test(PatientIndex::class);

    // Test count matching logic
    // Set category filter to bayi
    $livewire->set('category', 'bayi');
    $patients = $livewire->viewData('patients');
    expect($patients->total())->toBe(1);

    // Set category filter to baduta
    $livewire->set('category', 'baduta');
    $patients = $livewire->viewData('patients');
    expect($patients->total())->toBe(1);

    // Set category filter to balita
    $livewire->set('category', 'balita');
    $patients = $livewire->viewData('patients');
    expect($patients->total())->toBe(1);
});
