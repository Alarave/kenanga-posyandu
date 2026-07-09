<?php

use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$logs = DB::table('activity_logs')->orderBy('id', 'desc')->limit(20)->get();
foreach ($logs as $l) {
    echo "ID: {$l->id} | User: {$l->user_name} | Action: {$l->action_type} | Description: {$l->description} | Time: {$l->created_at}\n";
}
