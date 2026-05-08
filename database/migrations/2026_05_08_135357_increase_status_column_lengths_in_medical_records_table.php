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
            $table->string('stunting_status', 100)->nullable()->change();
            $table->string('wasting_status', 100)->nullable()->change();
            $table->string('weight_status', 100)->nullable()->change();
            $table->string('kpsp_status', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('stunting_status', 30)->change();
            $table->string('wasting_status', 30)->change();
            $table->string('weight_status', 50)->change();
            $table->string('kpsp_status', 50)->change();
        });
    }
};
