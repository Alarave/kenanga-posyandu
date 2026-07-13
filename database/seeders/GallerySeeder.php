<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryFolder;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class GallerySeeder extends Seeder
{
    public function run()
    {
        // Cek apakah sudah ada folder gallery
        if (GalleryFolder::whereNotNull('id')->exists()) {
            $this->command->info('Gallery folders sudah ada, skip seeder.');
            return;
        }

        $posyandu1 = Posyandu::where('unique_code', 'PSY003')->first();
        $posyandu2 = Posyandu::where('unique_code', 'PSY002')->first();
        $user = User::first();

        if (!$posyandu1 || !$user) {
            $this->command->error('Posyandu atau User belum ada. Jalankan PosyanduSeeder dan UserSeeder terlebih dahulu.');
            return;
        }

        // Gambar placeholder dari picsum.photos (reliable)
        $imageUrls = [
            'https://picsum.photos/seed/posyandu1/800/600',
            'https://picsum.photos/seed/posyandu2/800/600',
            'https://picsum.photos/seed/posyandu3/800/600',
            'https://picsum.photos/seed/posyandu4/800/600',
            'https://picsum.photos/seed/posyandu5/800/600',
            'https://picsum.photos/seed/posyandu6/800/600',
            'https://picsum.photos/seed/posyandu7/800/600',
        ];

        $this->command->info('Mengunduh gambar placeholder...');

        $downloadedPaths = [];
        foreach ($imageUrls as $index => $url) {
            try {
                $contents = @file_get_contents($url);
                if ($contents !== false) {
                    $filename = 'galleries/' . Str::random(40) . '.jpg';
                    Storage::disk('public')->put($filename, $contents);
                    $downloadedPaths[] = $filename;
                    $this->command->info("Download {$index}: OK");
                }
            } catch (\Exception $e) {
                $this->command->warn("Gagal download gambar {$index}: " . $e->getMessage());
            }
        }

        // Download gambar untuk cover folder
        $coverPaths = [];
        $coverUrls = [
            'https://picsum.photos/seed/cover1/1200/800',
            'https://picsum.photos/seed/cover2/1200/800',
        ];
        foreach ($coverUrls as $index => $url) {
            try {
                $contents = @file_get_contents($url);
                if ($contents !== false) {
                    $filename = 'gallery_covers/' . Str::random(40) . '.jpg';
                    Storage::disk('public')->put($filename, $contents);
                    $coverPaths[] = $filename;
                    $this->command->info("Cover {$index}: OK");
                }
            } catch (\Exception $e) {
                $this->command->warn("Gagal download cover {$index}: " . $e->getMessage());
            }
        }

        // Buat folder 1: Imunisasi April 2026
        $folder1 = GalleryFolder::create([
            'posyandu_id' => $posyandu1?->id,
            'user_id'     => $user->id,
            'name'        => 'Imunisasi April 2026',
            'description' => 'Dokumentasi kegiatan imunisasi rutin bulan April 2026 di Posyandu Kenanga 1.',
            'cover_photo' => $coverPaths[0] ?? null,
        ]);

        $galleryTitles1 = [
            'Pengecekan Tensi',
            'Foto bersama kader posyandu kenanga 1 dan petugas kesehatan dari puskesmas',
            'Penimbangan BB',
            'Pengecekan',
        ];

        foreach ($galleryTitles1 as $i => $title) {
            if (isset($downloadedPaths[$i])) {
                Gallery::create([
                    'gallery_folder_id' => $folder1->id,
                    'posyandu_id'       => $posyandu1?->id,
                    'user_id'           => $user->id,
                    'title'             => $title,
                    'description'       => 'Kegiatan posyandu: ' . $title,
                    'photo'             => $downloadedPaths[$i],
                    'type'              => 'image',
                ]);
            }
        }

        // Buat folder 2: Penimbangan Rutin Mei 2026
        $posyanduTarget2 = $posyandu2 ?? $posyandu1;
        $folder2 = GalleryFolder::create([
            'posyandu_id' => $posyanduTarget2->id,
            'user_id'     => $user->id,
            'name'        => 'Penimbangan Rutin Mei 2026',
            'description' => 'Dokumentasi kegiatan penimbangan dan pemantauan tumbuh kembang balita bulan Mei 2026.',
            'cover_photo' => $coverPaths[1] ?? null,
        ]);

        $galleryTitles2 = [
            'Penimbangan Balita',
            'Pemeriksaan Gizi',
            'Konsultasi Ibu dan Anak',
        ];

        foreach ($galleryTitles2 as $i => $title) {
            $photoIndex = 4 + $i;
            if (isset($downloadedPaths[$photoIndex])) {
                Gallery::create([
                    'gallery_folder_id' => $folder2->id,
                    'posyandu_id'       => $posyanduTarget2->id,
                    'user_id'           => $user->id,
                    'title'             => $title,
                    'description'       => 'Kegiatan posyandu: ' . $title,
                    'photo'             => $downloadedPaths[$photoIndex],
                    'type'              => 'image',
                ]);
            }
        }

        $this->command->info('Gallery seeder selesai! Folder: 2, Total media: ' . Gallery::whereNotNull('gallery_folder_id')->count());
    }
}
