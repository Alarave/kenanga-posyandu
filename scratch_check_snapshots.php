<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\AnalyticsSnapshot;

$snapshots = AnalyticsSnapshot::all();
echo "Total Snapshots: " . $snapshots->count() . "\n";
foreach ($snapshots as $s) {
    echo "ID: {$s->id}, Posyandu ID: {$s->posyandu_id}, Key: {$s->key}, Created At: {$s->created_at}\n";
    // Let's print out if trendAvgWeight has non-zero values
    $data = $s->data['analytics_data'] ?? [];
    echo "  trendAvgWeight: " . json_encode($data['trendAvgWeight'] ?? null) . "\n";
}
