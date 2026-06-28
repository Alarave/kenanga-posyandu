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
        if (!Schema::hasColumn('galleries', 'gallery_folder_id')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->foreignId('gallery_folder_id')
                      ->nullable()
                      ->after('user_id')
                      ->constrained('gallery_folders')
                      ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('galleries', 'gallery_folder_id')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->dropForeign(['gallery_folder_id']);
                $table->dropColumn('gallery_folder_id');
            });
        }
    }
};
