<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Imports\Processors\PatientRowProcessor;

// Reset patient H. Amri gender to L first
$amri = \App\Models\Patient::where('id_number_hash', \App\Models\Patient::generateBlindIndex('3275011704550020'))->first();
if ($amri) {
    $amri->gender = 'L';
    $amri->save();
}

$processor = new PatientRowProcessor(1, 1);

$row = [
    '3275011704550020', // NIK
    'H. Amri',          // nama
    '1955-04-17',       // tgl_lahir
    'L',                // jk
    'Aren Jaya, RT 01',  // alamat
];

$colMap = [
    'nik' => 0,
    'nama_anak' => 1,
    'tgl_lahir' => 2,
    'jk' => 3,
    'alamat' => 4,
];

$processor->processSingleRow($row, $colMap, 1);

$patient = \App\Models\Patient::where('id_number_hash', \App\Models\Patient::generateBlindIndex('3275011704550020'))->first();
echo "Gender after import: " . $patient->gender . "\n";
