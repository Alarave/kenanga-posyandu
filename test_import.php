<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$csvContent = "No,Nama Balita,Nama Ortu,RT/RW,Jenis Kelamin,Tanggal Lahir,Umur (bulan),BB (KG),TB (CM),N,T,O,B,Status Gizi,Gakin,Catatan\n";
$csvContent .= "1,Ahmad,Budi,01/01,Laki-laki,01/01/2020,36,10,80,,,,,,,\n";
$csvContent .= "2,Budi,Cici,01/01,L,01/01/2020,36,10,80,,,,,,,\n";
$csvContent .= "3,Putra,Bapak,01/01,L,01/01/2020,36,10,80,,,,,,,\n";

file_put_contents('test_import.csv', $csvContent);

$file = new \Illuminate\Http\UploadedFile(
    'test_import.csv',
    'test_import.csv',
    'text/csv',
    null,
    true
);

$importer = new \App\Imports\PatientImport(1, 1);
try {
    $importer->import($file);
    echo "Import success.\n";
    print_r($importer->errors);
    
    $patients = \App\Models\Patient::whereIn('full_name', ['Ahmad', 'Budi', 'Putra'])->get();
    foreach($patients as $p) {
        echo "{$p->full_name} -> {$p->gender}\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
