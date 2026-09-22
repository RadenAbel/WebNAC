<?php

namespace App\Models\Concerns;

use App\Support\PublicCache;

/**
 * Pasang di model yang datanya tampil di halaman publik. Setiap kali data
 * model ini disimpan atau dihapus (dari halaman admin), semua cache halaman
 * publik otomatis dibuang — pengunjung langsung melihat data terbaru tanpa
 * perlu menjalankan "php artisan cache:clear".
 *
 * Nama method boot{NamaTrait} otomatis dipanggil Laravel, jadi tidak
 * bentrok dengan method booted() yang mungkin sudah ada di model.
 */
trait FlushesPublicCache
{
    public static function bootFlushesPublicCache(): void
    {
        static::saved(fn () => PublicCache::flush());
        static::deleted(fn () => PublicCache::flush());
    }
}