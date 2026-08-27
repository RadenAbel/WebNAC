<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_member_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('event');          // Nomor, mis. "50m Gaya Bebas"
            $table->string('time');           // Waktu, mis. "24.50"
            $table->string('medal')->nullable();          // Medali: Emas/Perak/Perunggu/-
            $table->unsignedSmallInteger('pool_length')->nullable(); // Panjang kolam (25/50 m)
            $table->unsignedTinyInteger('age_at_record')->nullable(); // Usia saat rekor dicetak
            $table->string('competition')->nullable();    // Nama kompetisi
            $table->string('country')->nullable();        // Negara
            $table->date('record_date')->nullable();      // Tanggal

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_member_records');
    }
};