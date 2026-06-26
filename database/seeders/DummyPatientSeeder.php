<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DummyPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $posyanduIds = \App\Models\Posyandu::pluck('id')->toArray();
        if (empty($posyanduIds)) {
            $posyanduIds = [1];
        }

        // --- 20 Ibu Hamil ---
        for ($i = 0; $i < 20; $i++) {
            $hpht = Carbon::now()->subMonths(rand(1, 8))->subDays(rand(1, 20));
            $age = rand(18, 40);
            
            $patient = Patient::create([
                'id_number' => $faker->unique()->numerify('################'),
                'full_name' => $faker->name('female'),
                'birth_date' => Carbon::now()->subYears($age)->subDays(rand(1, 365)),
                'gender' => 'P',
                'category' => 'ibu_hamil',
                'posyandu_id' => $faker->randomElement($posyanduIds),
                'status_mutasi' => 'aktif',
                'hpht' => $hpht->format('Y-m-d'),
                'address' => $faker->address,
            ]);

            // Add 1-6 medical records for this year
            $visitCount = rand(1, 6);
            for ($v = 0; $v < $visitCount; $v++) {
                MedicalRecord::create([
                    'patient_id' => $patient->id,
                    'user_id' => \App\Models\User::first()->id ?? 1,
                    'visit_date' => Carbon::now()->subMonths($v)->subDays(rand(1, 5)),
                    'weight' => rand(50, 80) + (rand(0, 9) / 10),
                    'height' => rand(145, 170),
                    'systolic_bp' => rand(100, 140),
                    'diastolic_bp' => rand(70, 90),
                    'hemoglobin' => rand(9, 13) + (rand(0, 9) / 10),
                    'gestational_age' => rand(4, 38),
                    'nakes_gives_fe_mms' => rand(0, 1),
                    'complaint' => '-',
                    'health_note' => '-',
                    'diagnosis' => '-',
                ]);
            }
        }

        // --- 20 Lansia ---
        for ($i = 0; $i < 20; $i++) {
            $age = rand(60, 85);
            
            $patient = Patient::create([
                'id_number' => $faker->unique()->numerify('################'),
                'full_name' => $faker->name,
                'birth_date' => Carbon::now()->subYears($age)->subDays(rand(1, 365)),
                'gender' => $faker->randomElement(['L', 'P']),
                'category' => 'lansia',
                'posyandu_id' => $faker->randomElement($posyanduIds),
                'status_mutasi' => 'aktif',
                'address' => $faker->address,
                'independence_status' => $faker->randomElement(['A', 'B', 'C']),
            ]);

            // Add records
            $visitCount = rand(1, 6);
            for ($v = 0; $v < $visitCount; $v++) {
                MedicalRecord::create([
                    'patient_id' => $patient->id,
                    'user_id' => \App\Models\User::first()->id ?? 1,
                    'visit_date' => Carbon::now()->subMonths($v)->subDays(rand(1, 5)),
                    'weight' => rand(45, 75) + (rand(0, 9) / 10),
                    'height' => rand(150, 170),
                    'systolic_bp' => rand(110, 160),
                    'diastolic_bp' => rand(70, 100),
                    'blood_sugar' => rand(80, 250),
                    'cholesterol' => rand(150, 300),
                    'uric_acid' => rand(4, 9) + (rand(0, 9) / 10),
                    'complaint' => '-',
                    'health_note' => '-',
                    'diagnosis' => '-',
                ]);
            }
        }
    }
}
