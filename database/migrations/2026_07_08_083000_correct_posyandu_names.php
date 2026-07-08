<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('posyandus')
            ->where('unique_code', 'PSY003')
            ->update(['name' => 'Posyandu Kenanga 1']);

        DB::table('posyandus')
            ->where('unique_code', 'PSY002')
            ->update(['name' => 'Posyandu Kenanga 2']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('posyandus')
            ->where('unique_code', 'PSY003')
            ->update(['name' => 'KENANGA 1']);

        DB::table('posyandus')
            ->where('unique_code', 'PSY002')
            ->update(['name' => 'KENANGA 2']);
    }
};
