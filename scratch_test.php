<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Patient;

$genders = Patient::select('gender', \DB::raw('count(*) as total'))
    ->groupBy('gender')
    ->get();

echo "Gender distribution in patients table:\n";
foreach ($genders as $g) {
    echo "  - Gender '{$g->gender}': {$g->total} patients\n";
}
