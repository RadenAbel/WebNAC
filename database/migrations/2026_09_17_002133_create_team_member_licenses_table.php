<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_member_licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');              // Nama lisensi, mis. "Pelatih Renang Level 1"
            $table->string('issuer')->nullable();          // Lembaga penerbit, mis. "PRSI"
            $table->string('license_number')->nullable();  // Nomor lisensi
            $table->date('issued_date')->nullable();        // Tanggal terbit
            $table->date('expiry_date')->nullable();        // Tanggal kedaluwarsa
            $table->string('certificate_file')->nullable(); // Upload sertifikat (PDF/gambar)

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_member_licenses');
    }
};