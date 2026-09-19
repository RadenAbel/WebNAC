<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('join_header_type')->default('photo')->after('team_header_youtube_url'); // photo | video
            $table->string('join_header_photo')->nullable()->after('join_header_type');
            $table->string('join_header_youtube_url')->nullable()->after('join_header_photo');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['join_header_type', 'join_header_photo', 'join_header_youtube_url']);
        });
    }
};