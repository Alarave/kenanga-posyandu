<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$str = '5/3-25';
$regex = '/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{2,4})$/';
$res = preg_match($regex, $str, $matches);
echo "Result: " . ($res ? 'MATCH' : 'NO MATCH') . "\n";
if ($res) {
    print_r($matches);
}
