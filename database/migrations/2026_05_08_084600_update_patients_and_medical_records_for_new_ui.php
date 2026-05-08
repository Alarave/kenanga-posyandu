<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('full_name');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->decimal('weight_at_birth', 5, 2)->nullable()->after('birth_date');
            $table->decimal('height_at_birth', 5, 2)->nullable()->after('weight_at_birth');
        });

        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('weight_status')->nullable()->after('weight');
            $table->string('kpsp_status')->nullable()->after('weight_status');
            $table->boolean('tbc_screening_cough')->default(false)->after('kpsp_status');
            $table->boolean('tbc_screening_fever')->default(false)->after('tbc_screening_cough');
            $table->boolean('tbc_screening_contact')->default(false)->after('tbc_screening_fever');
            $table->text('other_symptoms')->nullable()->after('tbc_screening_contact');
            $table->string('pmt_given')->nullable()->after('other_symptoms');
            $table->text('counseling_notes')->nullable()->after('pmt_given');
            $table->string('referral_type')->default('None')->after('counseling_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['father_name', 'mother_name', 'weight_at_birth', 'height_at_birth']);
        });

        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn([
                'weight_status',
                'kpsp_status',
                'tbc_screening_cough',
                'tbc_screening_fever',
                'tbc_screening_contact',
                'other_symptoms',
                'pmt_given',
                'counseling_notes',
                'referral_type',
            ]);
        });
    }
};
