<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Total Users in DB: " . \App\Models\User::count() . "\n";
echo "Active Users in DB: " . \App\Models\User::where('is_active', true)->count() . "\n";
echo "Inactive Users in DB: " . \App\Models\User::where('is_active', false)->count() . "\n";
echo "Active Kaders (superadmin, admin, kader): " . \App\Models\User::whereIn('role', ['superadmin', 'admin', 'kader'])->where('is_active', true)->count() . "\n";
echo "Total Posyandu: " . \App\Models\Posyandu::count() . "\n";

foreach (\App\Models\User::select('role', 'is_active', \DB::raw('count(*) as count'))->groupBy('role', 'is_active')->get() as $row) {
    echo "Role: {$row->role}, Active: " . ($row->is_active ? 'Yes' : 'No') . ", Count: {$row->count}\n";
}
