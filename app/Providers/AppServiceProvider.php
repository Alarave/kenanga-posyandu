<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register any services if needed
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Contoh penggabungan konfigurasi dengan benar
        $defaultConfig = config('app'); // Mengambil konfigurasi default dari file config/app.php
        $newConfig = [
            'key' => 'value',
            'another_key' => 'another_value',
        ];

        // Pastikan kedua argumen adalah array sebelum melakukan penggabungan
        if (is_array($defaultConfig) && is_array($newConfig)) {
            // Menggabungkan konfigurasi default dengan konfigurasi baru
            $mergedConfig = array_merge($defaultConfig, $newConfig);

            // Menggunakan konfigurasi yang telah digabungkan (misalnya menetapkannya kembali ke aplikasi)
            // Ini akan memperbarui konfigurasi yang ada di dalam aplikasi
            config(['app' => $mergedConfig]); // Memperbarui konfigurasi 'app'
        }
    }
}

