<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function normalizeGender(string $jk): ?string
{
    $original = $jk;
    $jk = strtoupper(trim($jk));
    $clean = str_replace([' ', '-', '.', '_', '/', '\\', '|'], '', $jk);

    // Exact matches - male
    if (in_array($clean, ['L', 'LK', 'LAKI', 'LAKILAKI', 'MALE', 'M', 'PRIA', 'LAKI2', 'COWOK', 'LAKIILAKI'], true)) {
        return 'L';
    }
    // Exact matches - female
    if (in_array($clean, ['P', 'PR', 'PEREMPUAN', 'FEMALE', 'F', 'WANITA', 'CEWEK', 'WAN', 'PRP'], true)) {
        return 'P';
    }

    // Substring / starts-with matching for longer values
    if (str_starts_with($clean, 'LAKI') || str_starts_with($clean, 'MALE') || str_starts_with($clean, 'PRIA')) {
        return 'L';
    }
    if (str_starts_with($clean, 'PEREMP') || str_starts_with($clean, 'FEMAL') || str_starts_with($clean, 'WANIT')) {
        return 'P';
    }

    // Handle "L/P" or "P/L" type combined values — take the first character
    if (strlen($clean) >= 1) {
        $first = $clean[0];
        if ($first === 'L') return 'L';
        if ($first === 'P') return 'P';
        if ($first === 'M') return 'L'; // M = Male
        if ($first === 'F') return 'P'; // F = Female
    }

    return null;
}

echo "Laki-laki: " . normalizeGender("Laki-laki") . "\n";
echo "Perempuan: " . normalizeGender("Perempuan") . "\n";
echo "L: " . normalizeGender("L") . "\n";
echo "P: " . normalizeGender("P") . "\n";
echo "LAKI-LAKI: " . normalizeGender("LAKI-LAKI") . "\n";
