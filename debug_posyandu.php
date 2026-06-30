<?php

require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$patients = \App\Models\Patient::where('category', 'lansia')->get(['id', 'posyandu_id']);
echo "Patients:\n".json_encode($patients)."\n";

$snapshots = \App\Models\AnalyticsSnapshot::get(['id', 'posyandu_id', 'key']);
echo "Snapshots:\n".json_encode($snapshots)."\n";
