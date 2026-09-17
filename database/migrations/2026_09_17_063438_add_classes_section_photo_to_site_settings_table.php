<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Foto background untuk section "Kelas NAC Swim School" di halaman
            // Tentang Kami (yang sebelumnya pakai foto placeholder statis).
            $table->string('classes_section_photo')->nullable()->after('about_photo');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('classes_section_photo');
        });
    }
};