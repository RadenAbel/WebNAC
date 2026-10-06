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

            $table->string('title');
            $table->string('issuer')->nullable();
            $table->string('license_number')->nullable();
            $table->date('issued_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('certificate_file')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_member_licenses');
    }
};
