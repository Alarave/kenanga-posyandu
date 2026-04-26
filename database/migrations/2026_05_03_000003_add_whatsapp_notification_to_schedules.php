<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom tracking notifikasi WhatsApp ke tabel schedules.
 * - whatsapp_notif_sent_at: timestamp kapan notifikasi dikirim (null = belum)
 * - whatsapp_notif_count: jumlah pesan WA yang berhasil dikirim
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->timestamp('whatsapp_notif_sent_at')->nullable()->after('status')
                ->comment('Timestamp pengiriman notifikasi WA terakhir');
            $table->unsignedSmallInteger('whatsapp_notif_count')->default(0)->after('whatsapp_notif_sent_at')
                ->comment('Jumlah notifikasi WA yang berhasil terkirim');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_notif_sent_at', 'whatsapp_notif_count']);
        });
    }
};
