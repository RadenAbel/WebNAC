<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Kenapa pakai DB::statement(), bukan Schema::table()->change()?
|--------------------------------------------------------------------------
| Mengubah TIPE kolom yang sudah ada (bukan menambah kolom baru) di Laravel
| normalnya butuh package "doctrine/dbal" terinstall. Supaya tidak perlu
| install package tambahan, migration ini langsung pakai raw SQL yang
| didukung native oleh MySQL.
*/
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE site_settings MODIFY map_embed_url TEXT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE site_settings MODIFY map_embed_url VARCHAR(255) NULL');
    }
};