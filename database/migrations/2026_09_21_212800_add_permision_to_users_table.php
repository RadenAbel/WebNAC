<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Daftar section yang boleh diakses akun ber-role 'admin', mis.
            // ["sliders","galleries","team"]. Diabaikan sepenuhnya untuk
            // 'super_admin' (selalu akses semua, lihat User::canAccess()).
            // Default NULL supaya akun lama (dibuat sebelum fitur ini ada)
            // otomatis dianggap "akses semua section" — lihat User::canAccess().
            $table->json('permissions')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('permissions');
        });
    }
};