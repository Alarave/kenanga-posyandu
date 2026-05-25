<?php

namespace Database\Seeders;

use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $kenanga1 = Posyandu::where('unique_code', 'PSY003')->firstOrFail();
        $kenanga2 = Posyandu::where('unique_code', 'PSY002')->firstOrFail();

        $kader1 = User::where('username', 'kader_kenanga1')->firstOrFail();
        $kader2 = User::where('username', 'kader_kenanga2')->firstOrFail();

        DB::table('schedules')->insert([
            [
                'posyandu_id' => $kenanga1->id,
                'user_id' => $kader1->id,
                'title' => 'Posyandu Bulanan',
                'description' => 'Kegiatan posyandu rutin bulanan untuk pemeriksaan bayi dan balita',
                'start_time' => now()->addDays(5),
                'end_time' => now()->addDays(5)->addHours(3),
                'location' => $kenanga1->name,
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'posyandu_id' => $kenanga2->id,
                'user_id' => $kader2->id,
                'title' => 'Imunisasi Campak',
                'description' => 'Program imunisasi campak untuk bayi usia 9 bulan',
                'start_time' => now()->addDays(7),
                'end_time' => now()->addDays(7)->addHours(2),
                'location' => $kenanga2->name,
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'posyandu_id' => $kenanga1->id,
                'user_id' => $kader1->id,
                'title' => 'Penyuluhan Gizi',
                'description' => 'Penyuluhan tentang gizi seimbang untuk ibu hamil dan balita',
                'start_time' => now()->addDays(10),
                'end_time' => now()->addDays(10)->addHours(2),
                'location' => $kenanga1->name,
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
