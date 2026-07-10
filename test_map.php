<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$resolver = new \App\Imports\Resolvers\HeaderResolver();
$headers = ['No', 'Nama Balita', 'Nama Ortu', 'RT/RW', 'Jenis Kelamin', 'Tanggal Lahir', 'Umur (bulan)', 'BB (KG)', 'TB (CM)', 'N', 'T', 'O', 'B', 'Status Gizi', 'Gakin', 'Catatan'];
$normalized = $resolver->normalizeHeaders($headers);
$map = $resolver->buildColumnMap($normalized);

print_r($normalized);
print_r($map);
