<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Posyandu;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $kenanga1 = Posyandu::where('unique_code', 'PSY003')->firstOrFail();
        $kenanga2 = Posyandu::where('unique_code', 'PSY002')->firstOrFail();

        $patients = [
            // ── KENANGA 1 ────────────────────────────────────────────────────
            [
                'posyandu_id' => $kenanga1->id,
                'category' => 'balita',
                'parent_name' => 'Bapak Fauzi',
                'id_number' => '1234567890123456',
                'full_name' => 'Ahmad Fauzi',
                'father_name' => 'Fauzi Ardiansyah',
                'mother_name' => 'Siti Nurhaliza',
                'weight_at_birth' => 3.2,
                'height_at_birth' => 50,
                'birth_date' => '2021-05-10',
                'gender' => 'L',
                'address' => 'Aren Jaya, RT 01',
                'phone_number' => '081234567890',
                'profile_photo' => null,
            ],
            [
                'posyandu_id' => $kenanga1->id,
                'category' => 'balita',
                'parent_name' => 'Ibu Aminah',
                'id_number' => '1234567890123457',
                'full_name' => 'Siti Aminah',
                'father_name' => 'Rahmad Hidayat',
                'mother_name' => 'Aminah Sari',
                'weight_at_birth' => 2.9,
                'height_at_birth' => 48,
                'birth_date' => '2022-08-15',
                'gender' => 'P',
                'address' => 'Aren Jaya, RT 02',
                'phone_number' => '081298765432',
                'profile_photo' => null,
            ],
            // ── KENANGA 2 ────────────────────────────────────────────────────
            [
                'posyandu_id' => $kenanga2->id,
                'category' => 'balita',
                'parent_name' => 'Bapak Santoso',
                'id_number' => '1234567890123458',
                'full_name' => 'Budi Santoso',
                'father_name' => 'Santoso Wijaya',
                'mother_name' => 'Rini Astuti',
                'weight_at_birth' => 3.5,
                'height_at_birth' => 51,
                'birth_date' => '2020-12-01',
                'gender' => 'L',
                'address' => 'Aren Jaya, RT 03',
                'phone_number' => '081212345678',
                'profile_photo' => null,
            ],
            [
                'posyandu_id' => $kenanga2->id,
                'category' => 'balita',
                'parent_name' => 'Bapak Lestari',
                'id_number' => '1234567890123459',
                'full_name' => 'Dewi Lestari',
                'father_name' => 'Lestari Budi',
                'mother_name' => 'Dewi Sartika',
                'weight_at_birth' => 3.1,
                'height_at_birth' => 49,
                'birth_date' => '2021-03-22',
                'gender' => 'P',
                'address' => 'Aren Jaya, RT 04',
                'phone_number' => '081223344556',
                'profile_photo' => null,
            ],
        ];

        foreach ($patients as $data) {
            Patient::updateOrCreate(
                ['id_number' => $data['id_number']],
                $data
            );
        }
    }
}
