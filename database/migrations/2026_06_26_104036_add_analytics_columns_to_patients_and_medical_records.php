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
            if (!Schema::hasColumn('patients', 'hpht')) {
                $table->date('hpht')->nullable()->after('birth_date');
            }
            if (!Schema::hasColumn('patients', 'status_mutasi')) {
                $table->string('status_mutasi')->default('aktif')->after('category');
            }
        });

        Schema::table('medical_records', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_records', 'hemoglobin')) {
                $table->decimal('hemoglobin', 5, 2)->nullable()->after('blood_sugar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'hpht')) {
                $table->dropColumn('hpht');
            }
            if (Schema::hasColumn('patients', 'status_mutasi')) {
                $table->dropColumn('status_mutasi');
            }
        });

        Schema::table('medical_records', function (Blueprint $table) {
            if (Schema::hasColumn('medical_records', 'hemoglobin')) {
                $table->dropColumn('hemoglobin');
            }
        });
    }
};
