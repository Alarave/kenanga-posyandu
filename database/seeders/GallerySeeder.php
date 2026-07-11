<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    public function run()
    {
        if (DB::table('galleries')->exists()) {
            return;
        }

        $items = [
            [
                'posyandu_id' => 1,
                'user_id' => 2,
                'title' => 'Kegiatan Posyandu Januari',
                'description' => 'Foto-foto kegiatan posyandu bulan Januari',
                'photo' => 'galleries/mPS2Z5BOZn32qMXbUY3oi1O4ronv0aK98iGaQpya.jpg',
                'type' => 'activity',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'posyandu_id' => 1,
                'user_id' => 2,
                'title' => 'Imunisasi Campak',
                'description' => 'Foto kegiatan imunisasi campak',
                'photo' => 'galleries/6q7QMwvCsyIMMyfH2JmFJf6quPU0sebiGylimEps.jpg',
                'type' => 'immunization',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'posyandu_id' => 2,
                'user_id' => 2,
                'title' => 'Penyuluhan Gizi',
                'description' => 'Foto kegiatan penyuluhan gizi',
                'photo' => 'galleries/LgezeX9kJO8zfJBRGJ0Kw9Tj06bPcmUeGQUpjM9P.jpg',
                'type' => 'education',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($items as $item) {
            DB::table('galleries')->updateOrInsert(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
