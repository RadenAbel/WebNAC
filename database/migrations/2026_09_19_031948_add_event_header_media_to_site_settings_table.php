<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('event_header_type')->default('photo')->after('gallery_header_youtube_url'); // photo | video
            $table->string('event_header_photo')->nullable()->after('event_header_type');
            $table->string('event_header_youtube_url')->nullable()->after('event_header_photo');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['event_header_type', 'event_header_photo', 'event_header_youtube_url']);
        });
    }
};