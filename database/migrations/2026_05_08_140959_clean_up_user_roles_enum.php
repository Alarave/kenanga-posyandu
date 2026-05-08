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
        // First delete any users that might have these roles
        DB::table('users')->whereIn('role', ['staff', 'medical', 'patient', 'partner', 'coordinator'])->delete();

        // Update the role enum in users table to only include active roles
        if (config('database.default') === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin', 'kader') DEFAULT 'admin'");
        } else {
            // Fallback for other drivers
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('admin')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin', 'coordinator', 'kader', 'staff', 'medical', 'patient', 'partner') DEFAULT 'admin'");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('admin')->change();
            });
        }
    }
};
