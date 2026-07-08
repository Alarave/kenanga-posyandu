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

        // ── LANSIA checkups (January to June 2026) ───────────────────
        $records = [
            // 05 Jan 2026
            [
                'patient_id' => $amri->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-01-05 09:00:00',
                'weight' => 73.0,
                'height' => 163.0,
                'systolic_bp' => 171,
                'diastolic_bp' => 76,
                'blood_sugar' => 125,
                'cholesterol' => 180,
                'uric_acid' => 5.8,
                'complaint' => 'Pegal di punggung',
                'diagnosis' => 'Pemantauan',
            ],
            [
                'patient_id' => $meita->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-01-05 09:00:00',
                'weight' => 74.0,
                'height' => 157.0,
                'systolic_bp' => 135,
                'diastolic_bp' => 79,
                'blood_sugar' => 95,
                'cholesterol' => 190,
                'uric_acid' => 4.2,
                'complaint' => 'Tidak ada keluhan',
                'diagnosis' => 'Sehat',
            ],
            // 02 Feb 2026
            [
                'patient_id' => $amri->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-02-02 09:00:00',
                'weight' => 73.0,
                'height' => 163.0,
                'systolic_bp' => 155,
                'diastolic_bp' => 76,
                'blood_sugar' => 120,
                'cholesterol' => 175,
                'uric_acid' => 5.7,
                'complaint' => 'Pegal di punggung',
                'diagnosis' => 'Pemantauan',
            ],
            [
                'patient_id' => $meita->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-02-02 09:00:00',
                'weight' => 74.0,
                'height' => 157.0,
                'systolic_bp' => 143,
                'diastolic_bp' => 76,
                'blood_sugar' => 98,
                'cholesterol' => 185,
                'uric_acid' => 4.3,
                'complaint' => 'Tidak ada keluhan',
                'diagnosis' => 'Sehat',
            ],
            // 02 Mar 2026
            [
                'patient_id' => $amri->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-03-02 09:00:00',
                'weight' => 71.0,
                'height' => 163.0,
                'systolic_bp' => 174,
                'diastolic_bp' => 83,
                'blood_sugar' => 130,
                'cholesterol' => 185,
                'uric_acid' => 5.9,
                'complaint' => 'Pegal di punggung',
                'diagnosis' => 'Pemantauan',
            ],
            [
                'patient_id' => $meita->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-03-02 09:00:00',
                'weight' => 72.0,
                'height' => 157.0,
                'systolic_bp' => 114,
                'diastolic_bp' => 82,
                'blood_sugar' => 100,
                'cholesterol' => 192,
                'uric_acid' => 4.1,
                'complaint' => 'Tidak ada keluhan',
                'diagnosis' => 'Sehat',
            ],
            // 01 Apr 2026
            [
                'patient_id' => $amri->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-04-01 09:00:00',
                'weight' => 72.0,
                'height' => 163.0,
                'systolic_bp' => 159,
                'diastolic_bp' => 70,
                'blood_sugar' => 125,
                'cholesterol' => 178,
                'uric_acid' => 5.8,
                'complaint' => 'Pegal di punggung',
                'diagnosis' => 'Pemantauan',
            ],
            [
                'patient_id' => $meita->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-04-01 09:00:00',
                'weight' => 71.0,
                'height' => 157.0,
                'systolic_bp' => 142,
                'diastolic_bp' => 82,
                'blood_sugar' => 96,
                'cholesterol' => 189,
                'uric_acid' => 4.2,
                'complaint' => 'Tidak ada keluhan',
                'diagnosis' => 'Sehat',
            ],
            // 04 Mei 2026
            [
                'patient_id' => $amri->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-05-04 09:00:00',
                'weight' => 73.0,
                'height' => 163.0,
                'systolic_bp' => 153,
                'diastolic_bp' => 68,
                'blood_sugar' => 122,
                'cholesterol' => 182,
                'uric_acid' => 5.7,
                'complaint' => 'Pegal di punggung',
                'diagnosis' => 'Pemantauan',
            ],
            [
                'patient_id' => $meita->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-05-04 09:00:00',
                'weight' => 71.0,
                'height' => 157.0,
                'systolic_bp' => 126,
                'diastolic_bp' => 75,
                'blood_sugar' => 97,
                'cholesterol' => 188,
                'uric_acid' => 4.3,
                'complaint' => 'Tidak ada keluhan',
                'diagnosis' => 'Sehat',
            ],
            // 02 June 2026
            [
                'patient_id' => $meita->id,
                'user_id' => $kaderKenanga1->id,
                'visit_date' => '2026-06-02 09:00:00',
                'weight' => 72.0,
                'height' => 157.0,
                'systolic_bp' => 133,
                'diastolic_bp' => 70,
                'blood_sugar' => 95,
                'cholesterol' => 190,
                'uric_acid' => 4.2,
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
