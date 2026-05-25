<?php

use App\Jobs\ComputeAnalyticsSnapshot;
use App\Models\AnalyticsSnapshot;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Pedukuhan;
use App\Models\Posyandu;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('compute analytics snapshot job calculates and stores metrics in snapshot table', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    // Create pregnancy patient with medical records
    $pregPatient = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'ibu_hamil',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $pregPatient->id,
        'systolic_bp' => 140,
        'diastolic_bp' => 90,
        'pill_fe' => 1,
        'visit_date' => now(),
    ]);

    // Create lansia patient with medical records
    $lansiaPatient = Patient::factory()->create([
        'posyandu_id' => $posyandu->id,
        'category' => 'lansia',
    ]);
    MedicalRecord::factory()->create([
        'patient_id' => $lansiaPatient->id,
        'systolic_bp' => 130,
        'diastolic_bp' => 80,
        'blood_sugar' => 210,
        'cholesterol' => 180,
        'uric_acid' => 7.5,
        'visit_date' => now(),
    ]);

    // Run the job
    ComputeAnalyticsSnapshot::dispatchSync($posyandu->id, now()->year, now()->month);

    // Assert a snapshot record was created
    $key = "year_" . now()->year . "_month_" . now()->month;
    $snapshot = AnalyticsSnapshot::where('posyandu_id', $posyandu->id)
        ->where('key', $key)
        ->first();

    expect($snapshot)->not->toBeNull();
    
    $analyticsData = $snapshot->data['analytics_data'];

    // Assert overview stats
    expect($analyticsData['totalIbuHamil'])->toBe(1);
    expect($analyticsData['totalLansia'])->toBe(1);
    expect($analyticsData['totalKunjungan'])->toBe(2);

    // Assert pregnancy stats
    expect($analyticsData['hypertensionRiskRate'])->toEqual(100.0);
    expect($analyticsData['feComplianceRate'])->toEqual(100.0);

    // Assert lansia stats
    expect($analyticsData['lansiaHypertensionRate'])->toEqual(0.0); // 130/80 is normal
    expect($analyticsData['lansiaHyperglycemiaRate'])->toEqual(100.0); // 210 >= 200
    expect($analyticsData['lansiaHypercholesterolemiaRate'])->toEqual(0.0); // 180 < 200
    expect($analyticsData['lansiaHyperuricemiaRate'])->toEqual(100.0); // 7.5 >= 7.0
});
