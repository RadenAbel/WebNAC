<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            // Kontak & sosial media pribadi
            $table->string('whatsapp')->nullable()->after('photo');
            $table->string('instagram_url')->nullable()->after('whatsapp');
            $table->string('facebook_url')->nullable()->after('instagram_url');
            $table->string('tiktok_url')->nullable()->after('facebook_url');

            // Profil tambahan
            $table->string('origin_city')->nullable()->after('category'); // Asal (kota)
            $table->unsignedTinyInteger('years_experience')->nullable()->after('origin_city'); // Lama pengalaman (tahun)

            // Ringkasan angka (ditampilkan di card/profil, diisi manual oleh admin)
            $table->unsignedInteger('total_medals')->default(0)->after('years_experience');
            $table->unsignedInteger('total_achievements')->default(0)->after('total_medals');
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp',
                'instagram_url',
                'facebook_url',
                'tiktok_url',
                'origin_city',
                'years_experience',
                'total_medals',
                'total_achievements',
            ]);
        });
    }
};