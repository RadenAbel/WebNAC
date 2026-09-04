<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_member_achievements', function (Blueprint $table) {
            // Simpan kode negara ISO 3166-1 alpha-2 (2 huruf, mis. "ID", "SG")
            // supaya bisa dikonversi otomatis jadi emoji bendera di tampilan.
            $table->string('country', 2)->nullable()->after('year');
        });
    }

    public function down(): void
    {
        Schema::table('team_member_achievements', function (Blueprint $table) {
            $table->dropColumn('country');
        });
    }
};