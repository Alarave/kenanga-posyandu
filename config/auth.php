<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Settings
    |--------------------------------------------------------------------------
    |
    | Opsi ini menentukan "guard" autentikasi default dan "broker" reset password
    | untuk aplikasi Anda. Anda dapat mengubah nilai ini sesuai kebutuhan,
    | namun ini adalah pengaturan awal yang baik untuk sebagian besar aplikasi.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat mendefinisikan setiap guard autentikasi untuk aplikasi Anda.
    | Konfigurasi default menggunakan penyimpanan sesi dan provider Eloquent.
    |
    | Setiap guard memiliki provider pengguna yang menentukan bagaimana pengguna
    | diambil dari database atau sistem penyimpanan lainnya.
    |
    | Driver yang didukung: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        // Jika Anda membutuhkan metode autentikasi lain seperti API, Anda dapat menambahkannya di sini
        // 'api' => [
        //     'driver' => 'passport',  // Contoh menggunakan Passport untuk API
        //     'provider' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Semua guard autentikasi memiliki provider pengguna yang menentukan bagaimana
    | pengguna diambil dari database atau sistem penyimpanan lainnya.
    | Biasanya menggunakan Eloquent.
    |
    | Jika Anda memiliki beberapa tabel atau model pengguna, Anda dapat mengonfigurasi
    | beberapa provider di sini dan mengaitkannya dengan guard yang sesuai.
    |
    | Driver yang didukung: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // Model pengguna yang digunakan
        ],
        // Contoh provider tambahan untuk model pengguna lain
        // 'admins' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Models\Admin::class,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    |
    | Konfigurasi ini menentukan perilaku fitur reset password Laravel,
    | termasuk tabel penyimpanan token dan provider pengguna yang digunakan.
    |
    | Expire adalah waktu dalam menit token reset password berlaku.
    | Throttle adalah waktu tunggu dalam detik sebelum pengguna dapat membuat
    | token reset password baru.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,  // Waktu berlaku token dalam menit
            'throttle' => 60, // Waktu tunggu sebelum membuat token baru dalam detik
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Waktu dalam detik sebelum konfirmasi password kedaluwarsa dan pengguna
    | diminta memasukkan ulang password mereka.
    | Default adalah 3 jam (10800 detik).
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
