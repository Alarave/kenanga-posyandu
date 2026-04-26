<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom Z-Score untuk 3 indeks antropometri tambahan:
 * - z_score_hfa: Height-for-Age (stunting)
 * - z_score_wfh: Weight-for-Height (wasting)
 * - z_score_bfa: BMI-for-Age (obesitas)
 * - stunting_status: Normal / Stunted / Severely Stunted
 * - wasting_status: Normal / Wasted / Severely Wasted / Overweight
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->decimal('z_score_hfa', 5, 2)->nullable()->after('z_score')
                ->comment('Z-Score Height-for-Age (stunting)');
            $table->decimal('z_score_wfh', 5, 2)->nullable()->after('z_score_hfa')
                ->comment('Z-Score Weight-for-Height (wasting)');
            $table->decimal('z_score_bfa', 5, 2)->nullable()->after('z_score_wfh')
                ->comment('Z-Score BMI-for-Age (obesitas)');
            $table->string('stunting_status', 30)->nullable()->after('nutrition_status');
            $table->string('wasting_status', 30)->nullable()->after('stunting_status');
        });
    }

    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['z_score_hfa', 'z_score_wfh', 'z_score_bfa', 'stunting_status', 'wasting_status']);
        });
    }
};
