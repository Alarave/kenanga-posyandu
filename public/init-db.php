<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Load Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>Database Initializer</h1>";

try {
    echo "<p>Running migrations...</p>";
    Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . Artisan::output() . "</pre>";

    echo "<p>Seeding database...</p>";
    Artisan::call('db:seed', ['--force' => true]);
    echo "<pre>" . Artisan::output() . "</pre>";

    echo "<p>Creating Gmail Admin account...</p>";
    User::updateOrCreate(
        ['email' => 'admin@gmail.com'],
        [
            'name' => 'Admin Gmail',
            'username' => 'admin_gmail',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'is_active' => true,
            'verified_email' => true,
        ]
    );
    echo "<p style='color: green;'>Success! You can now login with:</p>";
    echo "<ul><li>Email: <b>admin@gmail.com</b></li><li>Password: <b>password123</b></li></ul>";
    
} catch (\Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='/login'>Go to Login</a></p>";
