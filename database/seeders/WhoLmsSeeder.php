<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder untuk data referensi WHO LMS (TB/U, BB/TB, IMT/U).
 * Data ini digunakan untuk perhitungan Z-Score yang lebih akurat.
 */
class WhoLmsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedHeightForAge();
        $this->seedWeightForHeight();
        $this->seedBmiForAge();
    }

    private function seedHeightForAge(): void
    {
        if (DB::connection()->getName() === 'mysql' && !DB::getSchemaBuilder()->hasTable('who_height_for_age')) return;
        if (DB::table('who_height_for_age')->count() > 0) return;

        $this->command->info('Mengisi data WHO Height-for-Age (TB/U)...');

        // Sample data for 0-6 months (Male)
        // age, L, M, S, -3SD, -2SD, +2SD, +3SD
        $maleData = [
            0 => [1, 49.884, 0.03795, 44.2, 46.1, 53.7, 55.6],
            1 => [1, 54.722, 0.03730, 48.9, 50.8, 58.6, 60.6],
            2 => [1, 58.423, 0.03681, 52.4, 54.4, 62.4, 64.4],
            3 => [1, 61.424, 0.03643, 55.3, 57.3, 65.5, 67.6],
            4 => [1, 63.886, 0.03612, 57.6, 59.7, 68.0, 70.1],
            5 => [1, 65.902, 0.03588, 59.6, 61.7, 70.1, 72.2],
            6 => [1, 67.625, 0.03568, 61.2, 63.3, 71.9, 74.0],
        ];

        foreach ($maleData as $age => $v) {
            DB::table('who_height_for_age')->insert([
                'gender' => 'M', 'age_months' => $age,
                'l_value' => $v[0], 'm_value' => $v[1], 's_value' => $v[2],
                'sd_minus3' => $v[3], 'sd_minus2' => $v[4], 'sd_plus2' => $v[5], 'sd_plus3' => $v[6]
            ]);
        }
        
        $this->command->info('WHO TB/U Seeder selesai (Sample 0-6 bln).');
    }

    private function seedWeightForHeight(): void
    {
        if (DB::connection()->getName() === 'mysql' && !DB::getSchemaBuilder()->hasTable('who_weight_for_height')) return;
        if (DB::table('who_weight_for_height')->count() > 0) return;

        $this->command->info('Mengisi data WHO Weight-for-Height (BB/TB)...');

        // Sample data for 45-50 cm (Male)
        // height, L, M, S, -3SD, -2SD, +2SD, +3SD
        $maleData = [
            45.0 => [-0.3521, 2.435, 0.1209, 1.7, 1.9, 3.1, 3.4],
            45.5 => [-0.3521, 2.531, 0.1205, 1.8, 2.0, 3.2, 3.5],
            46.0 => [-0.3521, 2.631, 0.1201, 1.9, 2.1, 3.3, 3.7],
            46.5 => [-0.3521, 2.735, 0.1197, 2.0, 2.2, 3.5, 3.8],
            47.0 => [-0.3521, 2.842, 0.1193, 2.0, 2.3, 3.6, 4.0],
        ];

        foreach ($maleData as $h => $v) {
            DB::table('who_weight_for_height')->insert([
                'gender' => 'M', 'height_cm' => $h,
                'l_value' => $v[0], 'm_value' => $v[1], 's_value' => $v[2],
                'sd_minus3' => $v[3], 'sd_minus2' => $v[4], 'sd_plus2' => $v[5], 'sd_plus3' => $v[6]
            ]);
        }
    }

    private function seedBmiForAge(): void
    {
        if (DB::connection()->getName() === 'mysql' && !DB::getSchemaBuilder()->hasTable('who_bmi_for_age')) return;
        if (DB::table('who_bmi_for_age')->count() > 0) return;

        // Similar pattern...
    }
}
