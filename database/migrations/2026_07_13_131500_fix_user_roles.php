<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix roles for seeded kader users to ensure they are 'kader' and not 'admin'
        DB::table('users')
            ->whereIn('email', [
                'kader.kenanga1@posyandu.com',
                'kader.kenanga2@posyandu.com',
            ])
            ->update(['role' => 'kader']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->whereIn('email', [
                'kader.kenanga1@posyandu.com',
                'kader.kenanga2@posyandu.com',
            ])
            ->update(['role' => 'admin']);
    }
};
