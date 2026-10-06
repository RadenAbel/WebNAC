<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();

            $table->string('swim_event', 100);
            $table->string('age_group', 50)->nullable();
            $table->string('gender', 10);

            $table->foreignId('team_member_id')->nullable()->constrained('team_members')->nullOnDelete();
            $table->string('athlete_name', 150);
            $table->date('birth_date')->nullable();
            $table->string('club', 150)->nullable();

            $table->unsignedSmallInteger('rank')->nullable();
            $table->string('time', 20)->nullable();
            $table->string('note', 20)->nullable();

            $table->timestamps();

            $table->index(['event_id', 'swim_event', 'age_group', 'gender'], 'event_results_group_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_results');
    }
};
