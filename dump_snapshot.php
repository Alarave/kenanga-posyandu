<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$snapshot = \App\Models\AnalyticsSnapshot::first();
if ($snapshot) {
    echo json_encode($snapshot->data['analytics_data']['trendLansiaHypertension'], JSON_PRETTY_PRINT);
} else {
    echo "NO SNAPSHOT";
}
