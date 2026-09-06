<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_member_achievements', function (Blueprint $table) {
            // Tanggal pertandingan/acara berlangsung — lebih presisi dari
            // kolom `year` yang cuma 4 digit tahun. `year` tetap dipertahankan
            // (dipakai buat tampilan singkat "(2024)"), event_date opsional
            // untuk yang butuh detail tanggal pastinya.
            $table->date('event_date')->nullable()->after('year');
        });
    }

    public function down(): void
    {
        Schema::table('team_member_achievements', function (Blueprint $table) {
            $table->dropColumn('event_date');
        });
    }
};