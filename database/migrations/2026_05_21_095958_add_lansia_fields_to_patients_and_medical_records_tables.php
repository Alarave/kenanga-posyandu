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
            $table->string('rt_domisili', 10)->nullable()->after('address');
            $table->text('historical_diseases')->nullable()->after('rt_domisili');
        });

        Schema::table('medical_records', function (Blueprint $table) {
            $table->unsignedInteger('systolic_bp')->nullable()->after('nutrition_status');
            $table->unsignedInteger('diastolic_bp')->nullable()->after('systolic_bp');
            $table->unsignedInteger('blood_sugar')->nullable()->after('diastolic_bp');
            $table->decimal('uric_acid', 4, 2)->nullable()->after('blood_sugar');
            $table->unsignedInteger('cholesterol')->nullable()->after('uric_acid');
            $table->text('current_medication')->nullable()->after('cholesterol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['rt_domisili', 'historical_diseases']);
        });

        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn([
                'systolic_bp',
                'diastolic_bp',
                'blood_sugar',
                'uric_acid',
                'cholesterol',
                'current_medication',
            ]);
        });
    }
};
