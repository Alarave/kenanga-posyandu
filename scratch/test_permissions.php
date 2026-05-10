<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Support\Facades\Gate;

$user = User::find(7);
if (!$user) {
    echo "User 7 not found\n";
    exit;
}

$patients = Patient::where('posyandu_id', $user->posyandu_id)->get();
echo "User: " . $user->name . " (Role: " . $user->role . ")\n";
echo "Can create MedicalRecord: " . (Gate::forUser($user)->allows('create', MedicalRecord::class) ? 'YES' : 'NO') . "\n";
echo "Can update MedicalRecord: " . (Gate::forUser($user)->allows('update', MedicalRecord::all()->first()) ? 'YES' : 'NO') . "\n";
echo "Total Patients for " . $user->name . ": " . $patients->count() . "\n";
