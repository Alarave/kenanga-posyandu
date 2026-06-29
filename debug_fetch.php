<?php

require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();
\Illuminate\Support\Facades\Auth::login($user);

$a = new \App\Livewire\Admin\Analytics;
$a->selectedYear = 2026;
$a->selectedMonth = null;
$a->selectedPosyandu = null;

$method = new \ReflectionMethod($a, 'fetchAnalyticsData');
$method->setAccessible(true);
$data = $method->invoke($a);

echo json_encode([
    'trendLansiaHypertension' => $data['trendLansiaHypertension'],
    'totalLansia' => $data['totalLansia'],
    'lansiaHypertensionRate' => $data['lansiaHypertensionRate'],
], JSON_PRETTY_PRINT);
