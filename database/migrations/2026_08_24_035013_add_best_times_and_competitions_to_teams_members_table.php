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
        Schema::table('team_members', function (Blueprint $table) {
            // Contoh isi: [{"style":"50m Gaya Bebas","time":"24.50","event":"PORPROV 2024"}, ...]
            $table->json('best_times')->nullable()->after('bio');

            // Contoh isi: [{"name":"PON XXI 2024","result":"Juara 1","year":"2024"}, ...]
            $table->json('competitions')->nullable()->after('best_times');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['best_times', 'competitions']);
        });
    }
};