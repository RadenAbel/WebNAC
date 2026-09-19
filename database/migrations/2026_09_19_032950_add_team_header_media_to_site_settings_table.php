<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Satu setting dipakai BERSAMA untuk halaman Atlet dan Pelatih
            // (sengaja tidak dipisah per halaman, sesuai permintaan).
            $table->string('team_header_type')->default('photo')->after('event_header_youtube_url'); // photo | video
            $table->string('team_header_photo')->nullable()->after('team_header_type');
            $table->string('team_header_youtube_url')->nullable()->after('team_header_photo');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['team_header_type', 'team_header_photo', 'team_header_youtube_url']);
        });
    }
};