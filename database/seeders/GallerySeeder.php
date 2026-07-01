<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    public function run()
    {
        $user = \App\Models\User::first();
        $userId = $user ? $user->id : 1;

        $posyandu = \App\Models\Posyandu::first();
        $posyanduId = $posyandu ? $posyandu->id : 1;

        DB::table('galleries')->insert([
            [
                'posyandu_id' => $posyanduId,
                'user_id' => $userId,
                'title' => 'Kegiatan Posyandu Januari',
                'description' => 'Foto-foto kegiatan posyandu bulan Januari',
                'photo' => 'kegiatan-januari.jpg',
                'type' => 'activity',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'posyandu_id' => $posyanduId,
                'user_id' => $userId,
                'title' => 'Imunisasi Campak',
                'description' => 'Foto kegiatan imunisasi campak',
                'photo' => 'imunisasi-campak.jpg',
                'type' => 'immunization',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'posyandu_id' => $posyanduId,
                'user_id' => $userId,
                'title' => 'Penyuluhan Gizi',
                'description' => 'Foto kegiatan penyuluhan gizi',
                'photo' => 'penyuluhan-gizi.jpg',
                'type' => 'education',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
