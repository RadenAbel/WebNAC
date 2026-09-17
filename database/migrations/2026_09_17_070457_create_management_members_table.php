<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position'); // jabatan, mis. "Ketua Umum & Pendiri"
            $table->string('photo')->nullable();
            $table->text('short_bio')->nullable();   // ringkasan singkat, tampil di kartu daftar
            $table->text('full_bio')->nullable();     // bio lengkap, boleh beberapa paragraf
                                                        // (dipisah admin pakai baris kosong antar paragraf)
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_members');
    }
};