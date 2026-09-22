<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * Mengecilkan & mengompres foto yang diupload sebelum disimpan:
 * - diperkecil supaya sisi terpanjangnya maksimal $maxDimension piksel
 *   (foto yang sudah kecil tidak diperbesar),
 * - diubah ke format WebP (jauh lebih ringan dari JPG/PNG, tetap
 *   mendukung background transparan untuk foto cutout & logo),
 * - orientasi foto HP diperbaiki (tidak miring/terbalik),
 * - data EXIF ikut terbuang, termasuk lokasi GPS tempat foto diambil.
 *
 * Hanya memakai GD bawaan PHP (tanpa package tambahan). Kalau GD tidak
 * aktif, formatnya tidak didukung (mis. GIF animasi), atau terjadi error
 * apa pun, file ASLI tetap disimpan seperti biasa — upload tidak pernah
 * gagal gara-gara proses kompresi ini.
 */
class ImageOptimizer
{
    /**
     * Simpan foto ke disk 'public' di dalam $directory, kembalikan path-nya
     * (sama seperti $file->store($directory, 'public')).
     */
    public static function store(
        UploadedFile $file,
        string $directory,
        int $maxDimension = 1600,
        int $quality = 80
    ): string {
        try {
            $path = static::optimize($file, $directory, $maxDimension, $quality);

            if ($path) {
                return $path;
            }
        } catch (Throwable $e) {
            report($e);
        }

        return $file->store($directory, 'public');
    }

    protected static function optimize(UploadedFile $file, string $directory, int $maxDimension, int $quality): ?string
    {
        if (! extension_loaded('gd') || ! function_exists('imagewebp')) {
            return null;
        }

        $realPath = $file->getRealPath();
        $mime = $file->getMimeType();

        static::ensureMemoryLimit();

        $source = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($realPath),
            'image/png'  => @imagecreatefrompng($realPath),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($realPath) : false,
            default      => false, // GIF (bisa animasi), SVG, dll — simpan apa adanya
        };

        if (! $source) {
            return null;
        }

        if ($mime === 'image/jpeg') {
            $source = static::fixOrientation($source, $realPath);
        }

        $width  = imagesx($source);
        $height = imagesy($source);
        $scale  = min(1, $maxDimension / max($width, $height));
        $newWidth  = max(1, (int) round($width * $scale));
        $newHeight = max(1, (int) round($height * $scale));

        // Kanvas baru dengan dukungan transparansi — supaya foto cutout (PNG
        // tanpa background) & logo tetap transparan setelah jadi WebP.
        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        imagefilledrectangle($canvas, 0, 0, $newWidth, $newHeight, imagecolorallocatealpha($canvas, 0, 0, 0, 127));
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        unset($source);

        ob_start();
        $ok = imagewebp($canvas, null, $quality);
        $binary = ob_get_clean();
        unset($canvas);

        if (! $ok || ! $binary) {
            return null;
        }

        // Foto yang sudah kecil & sudah terkompres kadang malah jadi lebih
        // besar setelah dikonversi — kalau begitu, simpan yang asli saja.
        if ($scale === 1 && strlen($binary) >= $file->getSize()) {
            return null;
        }

        $path = trim($directory, '/') . '/' . Str::random(40) . '.webp';
        Storage::disk('public')->put($path, $binary);

        return $path;
    }

    /**
     * Foto dari HP sering tersimpan "miring" dan cuma ditandai lewat data
     * EXIF (Orientation). Karena EXIF dibuang saat konversi, rotasinya
     * diterapkan langsung ke gambar supaya tampil tegak.
     */
    protected static function fixOrientation($image, string $path)
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($path);
        $orientation = is_array($exif) ? ($exif['Orientation'] ?? 1) : 1;

        $angle = match ((int) $orientation) {
            3 => 180,
            6 => -90,
            8 => 90,
            default => 0,
        };

        if ($angle === 0) {
            return $image;
        }

        $rotated = imagerotate($image, $angle, 0);

        return $rotated ?: $image;
    }

    /**
     * Foto HP resolusi tinggi (mis. 4000x3000) butuh memori ±100 MB saat
     * diproses. Naikkan batas memori sementara kalau pengaturan PHP-nya
     * lebih kecil dari itu (tidak menurunkan kalau sudah lebih besar).
     */
    protected static function ensureMemoryLimit(): void
    {
        $current = ini_get('memory_limit');

        if ($current === '-1' || $current === false) {
            return;
        }

        $bytes = (int) $current;
        $unit = strtoupper(substr(trim($current), -1));
        $bytes *= match ($unit) {
            'G' => 1024 ** 3,
            'M' => 1024 ** 2,
            'K' => 1024,
            default => 1,
        };

        if ($bytes < 256 * 1024 ** 2) {
            @ini_set('memory_limit', '256M');
        }
    }
}