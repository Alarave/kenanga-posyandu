<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Membuat 3 tabel standar WHO LMS untuk perhitungan Z-Score Antropometri lengkap.
 * Rumus LMS: Z = ((y/M)^L - 1) / (L × S)
 * Sumber: WHO Child Growth Standards 2006 (NCHS/CDC)
 */
return new class extends Migration
{
    public function up(): void
    {
        // TB/U — Height-for-Age (deteksi stunting)
        Schema::create('who_height_for_age', function (Blueprint $table) {
            $table->id();
            $table->enum('gender', ['M', 'F'])->comment('M=Laki-laki, F=Perempuan');
            $table->unsignedTinyInteger('age_months')->comment('Usia dalam bulan (0-60)');
            $table->decimal('l_value', 8, 5)->comment('L (Box-Cox power)');
            $table->decimal('m_value', 8, 5)->comment('M (Median)');
            $table->decimal('s_value', 8, 5)->comment('S (Coefficient of variation)');
            // SD cutoffs for quick reference
            $table->decimal('sd_minus3', 5, 1);
            $table->decimal('sd_minus2', 5, 1);
            $table->decimal('sd_plus2', 5, 1);
            $table->decimal('sd_plus3', 5, 1);

            $table->unique(['gender', 'age_months']);
        });

        // BB/TB — Weight-for-Height (deteksi wasting/kurus)
        Schema::create('who_weight_for_height', function (Blueprint $table) {
            $table->id();
            $table->enum('gender', ['M', 'F']);
            $table->decimal('height_cm', 5, 1)->comment('Tinggi badan dalam cm (45.0–120.0)');
            $table->decimal('l_value', 8, 5);
            $table->decimal('m_value', 8, 5);
            $table->decimal('s_value', 8, 5);
            $table->decimal('sd_minus3', 5, 2);
            $table->decimal('sd_minus2', 5, 2);
            $table->decimal('sd_plus2', 5, 2);
            $table->decimal('sd_plus3', 5, 2);

            $table->unique(['gender', 'height_cm']);
        });

        // IMT/U — BMI-for-Age (deteksi obesitas)
        Schema::create('who_bmi_for_age', function (Blueprint $table) {
            $table->id();
            $table->enum('gender', ['M', 'F']);
            $table->unsignedTinyInteger('age_months')->comment('Usia dalam bulan (0-60)');
            $table->decimal('l_value', 8, 5);
            $table->decimal('m_value', 8, 5);
            $table->decimal('s_value', 8, 5);
            $table->decimal('sd_minus3', 5, 2);
            $table->decimal('sd_minus2', 5, 2);
            $table->decimal('sd_plus1', 5, 2);
            $table->decimal('sd_plus2', 5, 2);
            $table->decimal('sd_plus3', 5, 2);

            $table->unique(['gender', 'age_months']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('who_bmi_for_age');
        Schema::dropIfExists('who_weight_for_height');
        Schema::dropIfExists('who_height_for_age');
    }
};
