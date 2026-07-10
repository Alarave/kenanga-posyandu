<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use App\Jobs\ComputeAnalyticsSnapshot;
use App\Models\Posyandu;
use Illuminate\Support\Facades\Schedule;

Schedule::command('posyandu:send-reminders')->dailyAt('08:00');

Schedule::call(function () {
    // Global Snapshot
    ComputeAnalyticsSnapshot::dispatch(null);

    // Per-Posyandu Snapshots
    foreach (Posyandu::cursor() as $posyandu) {
        ComputeAnalyticsSnapshot::dispatch($posyandu->id);
    }
})->hourly();
