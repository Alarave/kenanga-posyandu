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
        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
                $table->string('user_name');
                $table->string('role', 50);
                $table->string('action_type', 100);
                $table->text('description');
                $table->string('entity_type', 100)->nullable();
                $table->unsignedBigInteger('entity_id')->nullable();
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->string('ip_address', 45);
                $table->timestamp('created_at')->useCurrent();
                
                // Indexes for efficient querying
                $table->index('user_id', 'idx_user_id');
                $table->index('action_type', 'idx_action_type');
                $table->index('created_at', 'idx_created_at');
                $table->index(['entity_type', 'entity_id'], 'idx_entity');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
