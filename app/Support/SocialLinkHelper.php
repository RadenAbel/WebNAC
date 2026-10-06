<?php

namespace App\Support;

class SocialLinkHelper
{
    public static function toFullUrl(?string $input, string $platform): ?string
    {
        if (! $input || trim($input) === '') {
            return null;
        }

        $input = trim($input);

        if (str_starts_with($input, 'http://') || str_starts_with($input, 'https://')) {
            $path = parse_url($input, PHP_URL_PATH) ?? '';
            $input = trim($path, '/');
        }

        $username = ltrim(trim($input, '/'), '@');

        if ($username === '') {
            return null;
        }

        return match ($platform) {
            'instagram' => "https://instagram.com/{$username}",
            'facebook'  => "https://facebook.com/{$username}",
            'youtube'   => 'https://youtube.com/@' . $username,
            'tiktok'    => 'https://tiktok.com/@' . $username,
            default     => $input,
        };
    }

    public static function extractUsername(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH) ?? '';

        return trim($path, '/') ?: null;
    }
}
