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
            $table->boolean('tbc_screening_lethargy')->default(false)->after('tbc_screening_contact')->comment('Anak Lesu / Tidak Aktif');
            $table->boolean('tbc_screening_lumps')->default(false)->after('tbc_screening_lethargy')->comment('Benjolan di Leher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['tbc_screening_lethargy', 'tbc_screening_lumps']);
        });
    }
};
