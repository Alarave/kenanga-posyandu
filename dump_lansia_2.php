<?php

use App\Models\MedicalRecord;
use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$records = MedicalRecord::whereHas('patient', function ($q) {
    $q->where('category', 'lansia');
})->get(['id', 'patient_id', 'visit_date', 'systolic_bp', 'diastolic_bp', 'blood_sugar', 'cholesterol', 'uric_acid'])->toArray();

echo json_encode($records, JSON_PRETTY_PRINT);
