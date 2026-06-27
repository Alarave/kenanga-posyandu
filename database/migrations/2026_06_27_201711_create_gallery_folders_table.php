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
        Schema::create('gallery_folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->foreignId('posyandu_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // Tambah folder_id ke tabel galleries
        Schema::table('galleries', function (Blueprint $table) {
            $table->foreignId('folder_id')->nullable()->after('posyandu_id')->constrained('gallery_folders')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeignIfExists(['folder_id']);
            $table->dropColumnIfExists('folder_id');
        });
        Schema::dropIfExists('gallery_folders');
    }
};
