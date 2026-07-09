<?php

use App\Livewire\Admin\Analytics;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Auth;

require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::first();
Auth::login($user);

$a = new Analytics;
$a->selectedYear = 2026;
$a->selectedMonth = null;
$a->selectedPosyandu = null;

$method = new ReflectionMethod($a, 'fetchAnalyticsData');
$method->setAccessible(true);
$data = $method->invoke($a);

echo json_encode([
    'trendLansiaHypertension' => $data['trendLansiaHypertension'],
    'totalLansia' => $data['totalLansia'],
    'lansiaHypertensionRate' => $data['lansiaHypertensionRate'],
], JSON_PRETTY_PRINT);
