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

            $table->string('event');
            $table->string('time');
            $table->string('medal')->nullable();
            $table->unsignedSmallInteger('pool_length')->nullable();
            $table->unsignedTinyInteger('age_at_record')->nullable();
            $table->string('competition')->nullable();
            $table->string('country')->nullable();
            $table->date('record_date')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_member_records');
    }
};
