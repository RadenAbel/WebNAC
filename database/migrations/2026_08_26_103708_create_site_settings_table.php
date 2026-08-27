<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| site_settings — dirancang sebagai tabel "singleton" (isinya cuma 1 baris)
|--------------------------------------------------------------------------
| Semua data perusahaan (logo, WA, sosmed, about us, alamat, jam) disimpan
| di 1 baris saja, diedit lewat 1 form pengaturan di admin — bukan tabel
| yang bisa nambah banyak baris.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Identitas
            $table->string('site_name')->default('Nugroho Aquatic Center');
            $table->string('logo')->nullable();
            $table->string('since_year', 4)->nullable(); // untuk badge "Sejak 2010"

            // Kontak & sosial media perusahaan
            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();

            // Lokasi & jam operasional
            $table->string('address')->nullable();
            $table->string('map_embed_url')->nullable();
            $table->string('opening_hours_weekday')->nullable(); // "06.00 - 21.00"
            $table->string('opening_hours_weekend')->nullable(); // "07.00 - 20.00"

            // About Us
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