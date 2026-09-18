<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('type')->default('photo')->after('image'); // photo | video
            $table->string('youtube_url')->nullable()->after('type');
            $table->string('image')->nullable()->change(); // opsional kalau type = video
        });
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['type', 'youtube_url']);
            $table->string('image')->nullable(false)->change();
        });
    }
};