<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_member_records', function (Blueprint $table) {
            $table->dropColumn('medal');
        });

        Schema::table('team_member_achievements', function (Blueprint $table) {
            $table->dropColumn(['total_gold', 'total_silver', 'total_bronze']);
        });
    }

    public function down(): void
    {
        Schema::table('team_member_records', function (Blueprint $table) {
            $table->string('medal')->nullable();
        });

        Schema::table('team_member_achievements', function (Blueprint $table) {
            $table->unsignedInteger('total_gold')->default(0);
            $table->unsignedInteger('total_silver')->default(0);
            $table->unsignedInteger('total_bronze')->default(0);
        });
    }
};
