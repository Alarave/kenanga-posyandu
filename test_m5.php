<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$selectedYear = 2026;
$m = 5;

$patientQuery = \App\Models\Patient::query();

$latestRecordSubqueryLM = \App\Models\MedicalRecord::selectRaw('MAX(id) as id')
    ->whereYear('visit_date', $selectedYear)
    ->whereMonth('visit_date', $m)
    ->groupBy('patient_id');

$lansiaWithRecordsM = (clone $patientQuery)
    ->where('category', 'lansia')
    ->whereHas('medicalRecords', fn($q) => $q->whereYear('visit_date', $selectedYear)->whereMonth('visit_date', $m));

$totalLM = $lansiaWithRecordsM->count();

$hyperLM = (clone $lansiaWithRecordsM)
    ->whereHas('medicalRecords', fn($q) => $q->where(fn($sq) => $sq->where('systolic_bp', '>=', 130)->orWhere('diastolic_bp', '>=', 80))->whereIn('id', $latestRecordSubqueryLM))
    ->count();

echo "totalLM: $totalLM\n";
echo "hyperLM: $hyperLM\n";
