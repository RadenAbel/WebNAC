<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_member_achievements', function (Blueprint $table) {
            $table->date('event_date')->nullable()->after('year');
        });
    }

    public function down(): void
    {
        Schema::table('team_member_achievements', function (Blueprint $table) {
            $table->dropColumn('event_date');
        });
    }
};
