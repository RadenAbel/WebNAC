<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            $table->string('site_name')->default('Nugroho Aquatic Center');
            $table->string('logo')->nullable();
            $table->string('since_year', 4)->nullable();

            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();

            $table->string('address')->nullable();
            $table->string('map_embed_url')->nullable();
            $table->string('opening_hours_weekday')->nullable();
            $table->string('opening_hours_weekend')->nullable();

            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->string('about_photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
