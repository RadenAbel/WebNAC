<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Foto background untuk section "Everglade Aquatic Center" (info
            // kolam tempat NAC berlatih) di halaman Tentang Kami.
            $table->string('pool_section_photo')->nullable()->after('classes_section_photo');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('pool_section_photo');
        });
    }
};