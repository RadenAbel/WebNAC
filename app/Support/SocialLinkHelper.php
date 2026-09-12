<?php

namespace App\Support;

class SocialLinkHelper
{
    /**
     * Bersihkan input dari admin — bisa berupa "username", "@username",
     * atau link lengkap yang ke-paste tidak sengaja — jadi URL lengkap
     * platform terkait, siap disimpan ke database.
     */
    public static function toFullUrl(?string $input, string $platform): ?string
    {
        if (! $input || trim($input) === '') {
            return null;
        }

        $input = trim($input);

        // Kalau ternyata admin paste link lengkap (mis. "https://instagram.com/radenabe"),
        // ambil username-nya saja dari path URL itu — supaya tidak dobel "https://" nanti.
        if (str_starts_with($input, 'http://') || str_starts_with($input, 'https://')) {
            $path = parse_url($input, PHP_URL_PATH) ?? '';
            $input = trim($path, '/');
        }

        // Buang '@' di depan kalau ada (umum diketik untuk handle sosmed)
        $username = ltrim(trim($input, '/'), '@');

        if ($username === '') {
            return null;
        }

        return match ($platform) {
            'instagram' => "https://instagram.com/{$username}",
            'facebook'  => "https://facebook.com/{$username}",
            'youtube'   => 'https://youtube.com/@' . $username, // konvensi handle YouTube pakai @
            'tiktok'    => 'https://tiktok.com/@' . $username, // konvensi TikTok selalu pakai @ di URL
            default     => $input,
        };
    }

    /**
     * Kebalikannya — ekstrak username dari URL lengkap yang tersimpan di
     * database, dipakai buat ngisi ulang form edit (biar admin lihat
     * username-nya saja, bukan link lengkapnya).
     */
    public static function extractUsername(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH) ?? '';

        return trim($path, '/') ?: null;
    }
}