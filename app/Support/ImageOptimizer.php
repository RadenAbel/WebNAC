<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ImageOptimizer
{
    public static function store(
        UploadedFile $file,
        string $directory,
        int $maxDimension = 1600,
        int $quality = 80,
        string $disk = 'public'
    ): string {
        try {
            $path = static::optimize($file, $directory, $maxDimension, $quality, $disk);

            if ($path) {
                return $path;
            }
        } catch (Throwable $e) {
            report($e);
        }

        return $file->store($directory, $disk);
    }

    protected static function optimize(UploadedFile $file, string $directory, int $maxDimension, int $quality, string $disk = 'public'): ?string
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
            default      => false,
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

        if ($scale === 1 && strlen($binary) >= $file->getSize()) {
            return null;
        }

        $path = trim($directory, '/') . '/' . Str::random(40) . '.webp';
        Storage::disk($disk)->put($path, $binary);

        return $path;
    }

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
