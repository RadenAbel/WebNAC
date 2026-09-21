<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->unsignedInteger('price'); // harga asli, dalam Rupiah (mis. 460000)
            $table->unsignedTinyInteger('discount_percent')->nullable(); // 1-100, null = tidak ada diskon
            $table->text('features')->nullable(); // 1 baris = 1 poin fitur, dipecah pakai explode("\n", ...)
            $table->boolean('is_highlighted')->default(false); // badge "Paling Diminati"
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};