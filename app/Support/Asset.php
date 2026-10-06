<?php

namespace App\Support;

class Asset
{
    private static array $resolved = [];

    public static function url(string $path): string
    {
        return static::$resolved[$path] ??= static::resolve($path);
    }

    private static function resolve(string $path): string
    {
        $source = public_path($path);
        $minPath = preg_replace('/\.(css|js)$/', '.min.$1', $path);
        $min = public_path($minPath);

        $sourceTime = @filemtime($source) ?: 0;
        $minTime = @filemtime($min) ?: 0;

        if ($minTime && $minTime >= $sourceTime) {
            return asset($minPath) . '?v=' . $minTime;
        }

        return asset($path) . ($sourceTime ? '?v=' . $sourceTime : '');
    }
}
