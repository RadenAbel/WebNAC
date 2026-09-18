<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('gallery_header_type')->default('photo')->after('pool_section_description'); // photo | video
            $table->string('gallery_header_photo')->nullable()->after('gallery_header_type');
            $table->string('gallery_header_youtube_url')->nullable()->after('gallery_header_photo');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['gallery_header_type', 'gallery_header_photo', 'gallery_header_youtube_url']);
        });
    }
};