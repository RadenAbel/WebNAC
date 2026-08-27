<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Kenapa kolom ini dihapus?
|--------------------------------------------------------------------------
| Sebelumnya best_times & competitions disimpan sebagai JSON di kolom
| team_members. Tapi karena Anda butuh form admin yang bisa nambah/hapus
| rekor & pencapaian satu per satu (bukan edit teks JSON mentah), datanya
| dipindah ke 2 tabel relasional terpisah:
|   - team_member_records      (gantikan best_times, lebih detail: medali,
|                                 panjang kolam, usia, kompetisi, negara, tanggal)
|   - team_member_achievements (gantikan competitions)
|
| Migration ini HARUS dijalankan setelah data lama (kalau ada) dipindahkan
| manual, karena down() tidak bisa mengembalikan isi datanya, hanya kolomnya.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['best_times', 'competitions']);
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->json('best_times')->nullable()->after('bio');
            $table->json('competitions')->nullable()->after('best_times');
        });
    }
};