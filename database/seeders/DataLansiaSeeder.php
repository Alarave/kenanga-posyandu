<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Posyandu;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DataLansiaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kenanga1 = Posyandu::where('unique_code', 'PSY003')->first();
        $kader = User::where('role', 'kader')->first();

        if (! $kenanga1) {
            $kenanga1 = Posyandu::first();
        }

        if (! $kader) {
            $kader = User::first();
        }

        // Generate 20 Lansia Patients
        for ($i = 0; $i < 20; $i++) {
            $age = rand(60, 85);
            $birthDate = Carbon::now()->subYears($age)->subDays(rand(1, 365));

            $patient = Patient::create([
                'id_number' => $faker->unique()->numerify('327501################'),
                'full_name' => $faker->name,
                'birth_date' => $birthDate->format('Y-m-d'),
                'gender' => $faker->randomElement(['L', 'P']),
                'category' => 'lansia',
                'posyandu_id' => $kenanga1->id,
                'status_mutasi' => 'aktif',
                'address' => $faker->address,
                'independence_status' => $faker->randomElement(['A', 'B', 'C']),
            ]);

            // Add Medical Records from January to Current Month for trend charts
            for ($month = 1; $month <= Carbon::now()->month; $month++) {
                // Decide if this patient has metabolic risks to show interesting data on dashboard
                $hasHipertensi = $faker->boolean(40); // 40% chance
                $hasHiperglikemia = $faker->boolean(30); // 30% chance
                $hasHiperkolesterolemia = $faker->boolean(35); // 35% chance
                $hasHiperurisemia = $faker->boolean(25); // 25% chance

                $systolic = $hasHipertensi ? rand(130, 180) : rand(110, 129);
                $diastolic = $hasHipertensi ? rand(80, 110) : rand(60, 79);
                $bloodSugar = $hasHiperglikemia ? rand(140, 300) : rand(90, 139);
                $cholesterol = $hasHiperkolesterolemia ? rand(190, 300) : rand(140, 189);
                $uricAcid = $hasHiperurisemia ? (rand(60, 100) / 10) : (rand(30, 59) / 10);

                // Height and Weight to calculate IMT
                $height = rand(150, 170);
                // Mix of Kurang, Normal, Lebih, Obesitas
                $weight = $faker->randomElement([45, 55, 65, 75, 85]);

                MedicalRecord::create([
                    'patient_id' => $patient->id,
                    'user_id' => $kader->id,
                    'visit_date' => Carbon::create(date('Y'), $month, rand(1, 28))->format('Y-m-d H:i:s'),
                    'weight' => $weight,
                    'height' => $height,
                    'systolic_bp' => $systolic,
                    'diastolic_bp' => $diastolic,
                    'blood_sugar' => $bloodSugar,
                    'cholesterol' => $cholesterol,
                    'uric_acid' => $uricAcid,
                    'complaint' => $faker->randomElement(['-', 'Pegal linu', 'Pusing', 'Cepat Lelah']),
                    'health_note' => 'Pemeriksaan rutin posyandu lansia',
                    'diagnosis' => '-',
                ]);
            }
        }
    }
}
