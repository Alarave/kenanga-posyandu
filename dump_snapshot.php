<?php

use App\Models\AnalyticsSnapshot;
use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$snapshot = AnalyticsSnapshot::first();
if ($snapshot) {
    echo json_encode($snapshot->data['analytics_data']['trendLansiaHypertension'], JSON_PRETTY_PRINT);
} else {
    echo 'NO SNAPSHOT';
}
