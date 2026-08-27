<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_member_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');            // Judul pencapaian/penghargaan
            $table->string('year', 4)->nullable();
            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_member_achievements');
    }
};