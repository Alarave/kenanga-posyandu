<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('activity_logs') || ! Schema::hasColumn('activity_logs', 'user_id')) {
            return;
        }

        $driver = DB::getDriverName();

        if (! in_array($driver, ['mysql', 'mariadb'], true)) {
            return;
        }

        $this->dropUserForeignKeys();

        DB::statement('ALTER TABLE `activity_logs` MODIFY `user_id` BIGINT UNSIGNED NULL');
        DB::statement(
            'ALTER TABLE `activity_logs` ADD CONSTRAINT `activity_logs_user_id_foreign` '.
            'FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('activity_logs') || ! Schema::hasColumn('activity_logs', 'user_id')) {
            return;
        }

        $driver = DB::getDriverName();

        if (! in_array($driver, ['mysql', 'mariadb'], true)) {
            return;
        }

        $this->dropUserForeignKeys();

        DB::statement(
            'ALTER TABLE `activity_logs` ADD CONSTRAINT `activity_logs_user_id_foreign` '.
            'FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT'
        );
    }

    private function dropUserForeignKeys(): void
    {
        $constraints = DB::select(
            'SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE '.
            'WHERE TABLE_SCHEMA = DATABASE() '.
            'AND TABLE_NAME = ? '.
            'AND COLUMN_NAME = ? '.
            'AND REFERENCED_TABLE_NAME = ?',
            ['activity_logs', 'user_id', 'users']
        );

        foreach ($constraints as $constraint) {
            DB::statement("ALTER TABLE `activity_logs` DROP FOREIGN KEY `{$constraint->CONSTRAINT_NAME}`");
        }
    }
};
