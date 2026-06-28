<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$records = \App\Models\MedicalRecord::whereHas('patient', function($q) { 
    $q->where('category', 'lansia'); 
})->get(['patient_id', 'systolic_bp', 'diastolic_bp', 'blood_sugar', 'cholesterol', 'uric_acid'])->toArray();

echo json_encode($records, JSON_PRETTY_PRINT);
