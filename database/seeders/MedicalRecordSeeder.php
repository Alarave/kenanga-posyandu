<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        // Resolve kader users by username so we never rely on hardcoded IDs
        // Resolve kader users by username
        $kaderKenanga1 = User::where('username', 'kader_kenanga1')->firstOrFail();
        $kaderKenanga2 = User::where('username', 'kader_kenanga2')->firstOrFail();

        // Resolve patients by NIK
        $amri = Patient::where('id_number', '3275011704550020')->firstOrFail();
        $meita = Patient::where('id_number', '3275015905630012')->firstOrFail();

        // ── LANSIA checkups (January to current month) ───────────────────
        for ($month = 1; $month <= now()->month; $month++) {
            $records = [
                [
                    'patient_id' => $amri->id,
                    'user_id' => $kaderKenanga1->id,
                    'visit_date' => \Carbon\Carbon::create(date('Y'), $month, 10)->format('Y-m-d H:i:s'),
                    'weight' => 65.5 + rand(-2, 2),
                    'height' => 165.0,
                    'systolic_bp' => 135 + rand(-10, 10),
                    'diastolic_bp' => 85 + rand(-5, 5),
                    'blood_sugar' => 125 + rand(-10, 15),
                    'cholesterol' => 180 + rand(-10, 10),
                    'uric_acid' => 5.8 + (rand(-5, 5) / 10),
                    'complaint' => 'Pegal di punggung',
                    'diagnosis' => 'Pemantauan',
                ],
                [
                    'patient_id' => $meita->id,
                    'user_id' => $kaderKenanga1->id,
                    'visit_date' => \Carbon\Carbon::create(date('Y'), $month, 10)->format('Y-m-d H:i:s'),
                    'weight' => 58.0 + rand(-2, 2),
                    'height' => 155.0,
                    'systolic_bp' => 120 + rand(-10, 10),
                    'diastolic_bp' => 80 + rand(-5, 5),
                    'blood_sugar' => 95 + rand(-5, 15),
                    'cholesterol' => 190 + rand(-15, 10),
                    'uric_acid' => 4.2 + (rand(-5, 5) / 10),
                    'complaint' => 'Tidak ada keluhan',
                    'diagnosis' => 'Sehat',
                ],
            ];

            foreach ($records as $data) {
                MedicalRecord::updateOrCreate(
                    [
                        'patient_id' => $data['patient_id'],
                        'visit_date' => $data['visit_date'],
                    ],
                    $data
                );
            }
        }
    }
}
