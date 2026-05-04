<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = app(\App\Services\ReportService::class);
$data = $service->generateMonthlyReport(2, 5, 2026);
$path = $service->exportToPdf($data, 'PokjaIV_Exact_Match');
echo $path;
