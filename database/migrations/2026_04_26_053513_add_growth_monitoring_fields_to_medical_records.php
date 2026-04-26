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
        Schema::table('medical_records', function (Blueprint $table) {
            $table->enum('measurement_method', ['recumbent', 'standing'])->default('recumbent')->after('height');
            $table->boolean('is_exclusive_breastfeeding')->default(false)->after('pill_fe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['measurement_method', 'is_exclusive_breastfeeding']);
        });
    }
};
