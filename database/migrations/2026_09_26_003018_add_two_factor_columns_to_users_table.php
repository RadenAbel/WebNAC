<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kode rahasia aplikasi authenticator — disimpan TERENKRIPSI (cast 'encrypted')
            $table->text('two_factor_secret')->nullable()->after('password');
            // Kode pemulihan (cadangan kalau HP hilang) — juga terenkripsi
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            // Terisi setelah admin berhasil memasukkan kode pertama kali (2FA benar-benar aktif)
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');
            // Penanda kode terakhir yang dipakai — mencegah kode yang sama dipakai dua kali
            $table->unsignedBigInteger('two_factor_last_used')->nullable()->after('two_factor_confirmed_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
                'two_factor_last_used',
            ]);
        });
    }
};