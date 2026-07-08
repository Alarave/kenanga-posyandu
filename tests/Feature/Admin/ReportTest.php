<?php

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('local');

    $this->posyandu1 = Posyandu::factory()->create(['name' => 'Posyandu A']);
    $this->posyandu2 = Posyandu::factory()->create(['name' => 'Posyandu B']);

    $this->superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);

    $this->admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $this->posyandu1->id,
    ]);

    $this->patient = Patient::factory()->create([
        'posyandu_id' => $this->posyandu1->id,
        'category' => 'balita',
    ]);

    $this->medicalRecord = MedicalRecord::factory()->create([
        'patient_id' => $this->patient->id,
        'user_id' => $this->admin->id,
        'visit_date' => now(),
        'weight' => 10.0,
        'height' => 75.0,
    ]);
});

describe('akses laporan per role', function () {
    it('superadmin dapat mengakses halaman laporan', function () {
        $this->actingAs($this->superadmin);
        $response = $this->get('/admin/reports');
        $response->assertOk();
    });

    it('admin dapat mengakses halaman laporan', function () {
        $this->actingAs($this->admin);
        $response = $this->get('/admin/reports');
        $response->assertOk();
    });

});

describe('ekspor Excel', function () {
    it('dapat mengekspor laporan ke Excel', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-excel', [
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        $response->assertDownload();
    });

    it('file Excel memiliki ekstensi .xlsx', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-excel', [
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        $contentDisposition = $response->headers->get('Content-Disposition');
        expect($contentDisposition)->toContain('.xlsx');
    });

    it('admin menggunakan posyandu sendiri saat ekspor meskipun mengirim posyandu_id lain', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu2->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        $contentDisposition = $response->headers->get('Content-Disposition');
        // Because the controller forces the admin's own posyandu, the filename will contain 'Posyandu_A'
        expect($contentDisposition)->toContain('Posyandu_A');
    });

    it('superadmin dapat mengekspor Excel untuk posyandu tertentu', function () {
        $this->actingAs($this->superadmin);

        $response = $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
    });

    it('membuat log aktivitas saat ekspor Excel', function () {
        $this->actingAs($this->admin);

        $this->post('/admin/reports/export-excel', [
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->admin->id,
            'action_type' => 'export_report',
        ]);
    });
});

describe('ekspor PDF', function () {
    it('dapat mengekspor laporan ke PDF', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-pdf', [
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        $response->assertDownload();
    });

    it('file PDF memiliki ekstensi .pdf', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-pdf', [
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        $contentDisposition = $response->headers->get('Content-Disposition');
        expect($contentDisposition)->toContain('.pdf');
    });

    it('membuat log aktivitas saat ekspor PDF', function () {
        $this->actingAs($this->admin);

        $this->post('/admin/reports/export-pdf', [
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->admin->id,
            'action_type' => 'export_report',
        ]);
    });
});

describe('performa ekspor', function () {
    it('ekspor Excel selesai dalam waktu wajar', function () {
        $this->actingAs($this->admin);
        $startTime = microtime(true);
        $response = $this->post('/admin/reports/export-excel', [
            'month' => now()->month,
            'year' => now()->year,
        ]);
        $executionTime = microtime(true) - $startTime;

        $response->assertOk();
        expect($executionTime)->toBeLessThan(10);
    });
});

describe('laporan individu ibu hamil', function () {
    it('dapat menghasilkan grafik SVG untuk ibu hamil', function () {
        $patient = Patient::factory()->create([
            'posyandu_id' => $this->posyandu1->id,
            'category' => 'ibu_hamil',
        ]);

        MedicalRecord::factory()->create([
            'patient_id' => $patient->id,
            'user_id' => $this->admin->id,
            'visit_date' => now()->subMonth(),
            'weight' => 50.0,
            'starting_weight' => 48.0,
            'upper_arm_circumference' => 24.0,
        ]);

        $reportService = app(App\Services\ReportService::class);
        $reportData = $reportService->generateIndividualReportData($patient, now()->month, now()->year, now()->month, now()->year);

        expect($reportData['svg_charts'])->toHaveKey('weight_gain');
        expect($reportData['svg_charts'])->toHaveKey('lila');
        expect($reportData['svg_charts']['weight_gain'])->toContain('<svg');
        expect($reportData['svg_charts']['lila'])->toContain('<svg');
    });

    it('dapat mengakses halaman rapor individu ibu hamil', function () {
        $patient = Patient::factory()->create([
            'posyandu_id' => $this->posyandu1->id,
            'category' => 'ibu_hamil',
        ]);

        $this->actingAs($this->superadmin);
        $response = $this->get(route('admin.reports.individual', $patient));
        $response->assertOk();
        $response->assertSee('Visualisasi Grafik Pemantauan Ibu Hamil');
    });
});

describe('monthly report livewire component', function () {
    it('can filter records by category', function () {
        $this->actingAs($this->admin);

        // Create patients of other categories
        $ibuHamilPatient = Patient::factory()->create([
            'posyandu_id' => $this->posyandu1->id,
            'category' => 'ibu_hamil',
            'full_name' => 'Ibu Test',
        ]);

        $lansiaPatient = Patient::factory()->create([
            'posyandu_id' => $this->posyandu1->id,
            'category' => 'lansia',
            'full_name' => 'Mbah Test',
        ]);

        // Create records
        MedicalRecord::factory()->create([
            'patient_id' => $ibuHamilPatient->id,
            'user_id' => $this->admin->id,
            'visit_date' => now(),
            'weight' => 60.0,
            'height' => 155.0,
        ]);

        MedicalRecord::factory()->create([
            'patient_id' => $lansiaPatient->id,
            'user_id' => $this->admin->id,
            'visit_date' => now(),
            'weight' => 50.0,
            'height' => 150.0,
        ]);

        // Test component default (all categories)
        Livewire::test(App\Livewire\Admin\Reports\MonthlyReport::class)
            ->assertSee($this->patient->full_name)
            ->assertSee($ibuHamilPatient->full_name)
            ->assertSee($lansiaPatient->full_name)
            // Filter to balita
            ->set('categoryFilter', 'balita')
            ->assertSee($this->patient->full_name)
            ->assertDontSee($ibuHamilPatient->full_name)
            ->assertDontSee($lansiaPatient->full_name)
            // Filter to ibu hamil
            ->set('categoryFilter', 'ibu_hamil')
            ->assertDontSee($this->patient->full_name)
            ->assertSee($ibuHamilPatient->full_name)
            ->assertDontSee($lansiaPatient->full_name)
            // Filter to lansia
            ->set('categoryFilter', 'lansia')
            ->assertDontSee($this->patient->full_name)
            ->assertDontSee($ibuHamilPatient->full_name)
            ->assertSee($lansiaPatient->full_name);
    });
});

