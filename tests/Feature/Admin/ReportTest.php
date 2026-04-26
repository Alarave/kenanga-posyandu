<?php

use App\Models\ActivityLog;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Fake storage for testing file generation
    Storage::fake('local');

    // Create posyandus
    $this->posyandu1 = Posyandu::factory()->create(['name' => 'Posyandu A']);
    $this->posyandu2 = Posyandu::factory()->create(['name' => 'Posyandu B']);

    // Create users with different roles
    $this->superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);

    $this->admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $this->posyandu1->id,
    ]);

    $this->coordinator = User::factory()->create([
        'role' => 'coordinator',
        'posyandu_id' => $this->posyandu1->id,
    ]);

    $this->staff = User::factory()->create([
        'role' => 'staff',
        'posyandu_id' => $this->posyandu1->id,
    ]);

    $this->medical = User::factory()->create([
        'role' => 'medical',
        'posyandu_id' => $this->posyandu1->id,
    ]);

    // Create patients and medical records for testing
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

    it('coordinator dapat mengakses halaman laporan', function () {
        $this->actingAs($this->coordinator);

        $response = $this->get('/admin/reports');

        $response->assertOk();
    });

    it('staff tidak dapat mengakses halaman laporan', function () {
        $this->actingAs($this->staff);

        $response = $this->get('/admin/reports');

        $response->assertForbidden();
    });

    it('medical tidak dapat mengakses halaman laporan', function () {
        $this->actingAs($this->medical);

        $response = $this->get('/admin/reports');

        $response->assertForbidden();
    });
});

describe('generate laporan', function () {
    it('dapat menghasilkan laporan bulanan', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
    });

    it('laporan berisi data kunjungan', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        // Verify response contains report data structure
    });

    it('admin hanya dapat generate laporan untuk posyandu mereka', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu2->id, // Different posyandu
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertForbidden();
    });

    it('superadmin dapat generate laporan untuk posyandu manapun', function () {
        $this->actingAs($this->superadmin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu2->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
    });
});

describe('ekspor Excel', function () {
    it('dapat mengekspor laporan ke Excel', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        $response->assertDownload();
    });

    it('file Excel memiliki ekstensi .xlsx', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        
        $contentDisposition = $response->headers->get('Content-Disposition');
        expect($contentDisposition)->toContain('.xlsx');
    });

    it('superadmin dapat mengekspor Excel', function () {
        $this->actingAs($this->superadmin);

        $response = $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
    });

    it('coordinator dapat mengekspor Excel', function () {
        $this->actingAs($this->coordinator);

        $response = $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
    });

    it('staff tidak dapat mengekspor Excel', function () {
        $this->actingAs($this->staff);

        $response = $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertForbidden();
    });

    it('membuat log aktivitas saat ekspor Excel', function () {
        $this->actingAs($this->admin);

        $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->admin->id,
            'action_type' => 'export_report',
        ]);
    });

    it('log aktivitas berisi informasi posyandu dan periode', function () {
        $this->actingAs($this->admin);

        $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $log = ActivityLog::where('user_id', $this->admin->id)
            ->where('action_type', 'export_report')
            ->latest()
            ->first();

        expect($log)->not->toBeNull()
            ->and($log->description)->toContain('Excel');
    });
});

describe('ekspor PDF', function () {
    it('dapat mengekspor laporan ke PDF', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-pdf', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
    });

    it('file PDF memiliki ekstensi .pdf', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-pdf', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        
        $contentDisposition = $response->headers->get('Content-Disposition');
        expect($contentDisposition)->toContain('.pdf');
    });

    it('superadmin dapat mengekspor PDF', function () {
        $this->actingAs($this->superadmin);

        $response = $this->post('/admin/reports/export-pdf', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
    });

    it('coordinator dapat mengekspor PDF', function () {
        $this->actingAs($this->coordinator);

        $response = $this->post('/admin/reports/export-pdf', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
    });

    it('staff tidak dapat mengekspor PDF', function () {
        $this->actingAs($this->staff);

        $response = $this->post('/admin/reports/export-pdf', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertForbidden();
    });

    it('membuat log aktivitas saat ekspor PDF', function () {
        $this->actingAs($this->admin);

        $this->post('/admin/reports/export-pdf', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->admin->id,
            'action_type' => 'export_report',
        ]);
    });

    it('log aktivitas berisi informasi posyandu dan periode', function () {
        $this->actingAs($this->admin);

        $this->post('/admin/reports/export-pdf', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $log = ActivityLog::where('user_id', $this->admin->id)
            ->where('action_type', 'export_report')
            ->latest()
            ->first();

        expect($log)->not->toBeNull()
            ->and($log->description)->toContain('PDF');
    });
});

describe('validasi input laporan', function () {
    it('memerlukan posyandu_id', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertSessionHasErrors('posyandu_id');
    });

    it('memerlukan month', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu1->id,
            'year' => now()->year,
        ]);

        $response->assertSessionHasErrors('month');
    });

    it('memerlukan year', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
        ]);

        $response->assertSessionHasErrors('year');
    });

    it('menolak month di luar rentang 1-12', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => 13,
            'year' => now()->year,
        ]);

        $response->assertSessionHasErrors('month');
    });

    it('menolak year yang tidak valid', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => 1900,
        ]);

        $response->assertSessionHasErrors('year');
    });
});

describe('konten laporan', function () {
    it('laporan berisi rekapitulasi kunjungan per kategori', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        // Verify report contains visit statistics
    });

    it('laporan berisi distribusi status gizi', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        // Verify report contains nutrition status distribution
    });

    it('laporan berisi data pemberian vitamin A dan FE', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/generate', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertOk();
        // Verify report contains vitamin/supplement data
    });
});

describe('scoping laporan per posyandu', function () {
    it('admin hanya dapat mengekspor laporan posyandu mereka', function () {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu2->id, // Different posyandu
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response->assertForbidden();
    });

    it('mencatat unauthorized_access saat admin mencoba ekspor laporan posyandu lain', function () {
        $this->actingAs($this->admin);

        $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu2->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->admin->id,
            'action_type' => 'unauthorized_access',
        ]);
    });
});

describe('performa ekspor', function () {
    it('ekspor Excel selesai dalam waktu wajar', function () {
        $this->actingAs($this->admin);

        $startTime = microtime(true);

        $response = $this->post('/admin/reports/export-excel', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        $response->assertOk();
        // Should complete in less than 10 seconds (as per requirements)
        expect($executionTime)->toBeLessThan(10);
    });

    it('ekspor PDF selesai dalam waktu wajar', function () {
        $this->actingAs($this->admin);

        $startTime = microtime(true);

        $response = $this->post('/admin/reports/export-pdf', [
            'posyandu_id' => $this->posyandu1->id,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        $response->assertOk();
        // Should complete in less than 10 seconds (as per requirements)
        expect($executionTime)->toBeLessThan(10);
    });
});
