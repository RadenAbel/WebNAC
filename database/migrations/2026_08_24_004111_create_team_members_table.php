<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable(); // path/nama file foto di storage
            $table->unsignedTinyInteger('age')->nullable();

            // Membedakan pelatih & atlit tanpa perlu 2 tabel
            $table->enum('role', ['pelatih', 'atlet']);

            // Kategori bebas: "Junior", "Senior", "Swim Class A",
            // "Swim Class B", "Head Coach", "Assistant Coach", dll.
            $table->string('category')->nullable();

            $table->text('bio')->nullable(); // opsional, deskripsi lebih panjang
            $table->unsignedInteger('sort_order')->default(0); // urutan tampil
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};