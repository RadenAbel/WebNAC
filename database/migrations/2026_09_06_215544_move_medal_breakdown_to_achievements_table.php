<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus dari team_members kalau migration sebelumnya sempat dijalankan
        // (pakai hasColumn supaya tetap aman walau belum sempat di-migrate).
        if (Schema::hasColumn('team_members', 'total_gold')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->dropColumn(['total_gold', 'total_silver', 'total_bronze']);
            });
        }

        Schema::table('team_member_achievements', function (Blueprint $table) {
            $table->unsignedInteger('total_gold')->default(0)->after('event_date');
            $table->unsignedInteger('total_silver')->default(0)->after('total_gold');
            $table->unsignedInteger('total_bronze')->default(0)->after('total_silver');
        });
    }

    public function down(): void
    {
        Schema::table('team_member_achievements', function (Blueprint $table) {
            $table->dropColumn(['total_gold', 'total_silver', 'total_bronze']);
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->unsignedInteger('total_gold')->default(0);
            $table->unsignedInteger('total_silver')->default(0);
            $table->unsignedInteger('total_bronze')->default(0);
        });
    }
};