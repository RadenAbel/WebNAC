<?php

namespace App\Support;

use Closure;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Cache;

/**
 * Cache untuk data yang tampil di halaman PUBLIK (Beranda, Tentang Kami,
 * daftar Atlet/Pelatih, Hasil Pertandingan) supaya database tidak ditanya
 * ulang setiap kali ada pengunjung.
 *
 * Cara kerja "versi":
 * Semua kunci cache publik diberi nomor versi (mis. "public.v7.home.gallery").
 * Begitu admin menyimpan/menghapus data apa pun yang tampil di halaman publik
 * (lihat trait FlushesPublicCache), nomor versi dinaikkan — semua cache lama
 * otomatis tidak terpakai lagi dan halaman publik langsung menampilkan data
 * terbaru. Cache lama yang tertinggal kedaluwarsa sendiri setelah TTL.
 *
 * PENTING: yang disimpan ke cache hanya data mentah (array/angka/teks),
 * BUKAN objek model — Laravel versi baru menolak membaca objek dari cache
 * (config cache.serializable_classes = false). Model dibentuk ulang lewat
 * hydrate() di method models().
 */
class PublicCache
{
    /** Jaring pengaman: cache tetap diperbarui paling lambat tiap 10 menit. */
    public const TTL = 600;

    private const VERSION_KEY = 'public_cache.version';

    private static ?int $version = null;

    /**
     * Cache hasil apa pun yang berupa array/angka/teks.
     */
    public static function remember(string $key, Closure $callback): mixed
    {
        return Cache::remember(static::key($key), self::TTL, $callback);
    }

    /**
     * Cache hasil query Eloquent. $query harus mengembalikan Collection model
     * (mis. fn () => Schedule::active()->get()). Hasilnya kembali berupa
     * Collection model biasa — accessor & cast tetap jalan seperti normal
     * (relasi tidak ikut tersimpan, jadi jangan dipakai untuk data yang
     * butuh relasi).
     *
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $modelClass
     */
    public static function models(string $key, string $modelClass, Closure $query): EloquentCollection
    {
        $rows = static::remember($key, function () use ($query) {
            return $query()->map(fn ($model) => $model->getAttributes())->values()->all();
        });

        return $modelClass::hydrate($rows);
    }

    /**
     * Buang SEMUA cache halaman publik (dengan menaikkan nomor versi).
     */
    public static function flush(): void
    {
        $next = static::version() + 1;
        Cache::forever(self::VERSION_KEY, $next);
        static::$version = $next;
    }

    private static function version(): int
    {
        return static::$version ??= (int) Cache::get(self::VERSION_KEY, 1);
    }

    private static function key(string $key): string
    {
        return 'public.v' . static::version() . '.' . $key;
    }
}