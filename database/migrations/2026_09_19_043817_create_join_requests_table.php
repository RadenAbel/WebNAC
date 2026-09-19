<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('join_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->date('birth_date');
            $table->string('whatsapp'); // disimpan APA ADANYA sesuai input (mis. "081234567890")
            $table->string('category');
            $table->string('photo')->nullable(); // path di storage/app/public — disimpan permanen (dulu cuma file temp buat lampiran email)

            // pending -> belum ditinjau admin
            // accepted -> diterima
            // rejected -> ditolak
            $table->string('status')->default('pending');
            $table->timestamp('responded_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('join_requests');
    }
};