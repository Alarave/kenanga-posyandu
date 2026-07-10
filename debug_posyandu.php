<?php

use App\Models\AnalyticsSnapshot;
use App\Models\Patient;
use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$patients = Patient::where('category', 'lansia')->get(['id', 'posyandu_id']);
echo "Patients:\n".json_encode($patients)."\n";

$snapshots = AnalyticsSnapshot::get(['id', 'posyandu_id', 'key']);
echo "Snapshots:\n".json_encode($snapshots)."\n";
