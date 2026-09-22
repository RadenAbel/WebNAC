<?php

namespace App\Support;

use App\Models\SiteSetting;

/**
 * Data terstruktur (schema.org JSON-LD) untuk Google.
 *
 * Dibuat di PHP (bukan ditulis langsung di Blade) karena JSON-LD penuh tanda
 * "@" ("@context", "@type") yang di Blade bisa disangka directive dan bikin
 * ParseError. Di sini cukup array biasa lalu di-json_encode.
 */
class Seo
{
    public static function clubSchema(SiteSetting $setting): string
    {
        $address = static::clean([
            '@type'           => 'PostalAddress',
            'streetAddress'   => $setting->address,
            'addressLocality' => config('seo.locality'),
            'addressRegion'   => config('seo.region'),
            'addressCountry'  => 'ID',
        ]);

        $logo = $setting->logo_url ?: asset('img/Logo.png');

        $data = static::clean([
            '@context'      => 'https://schema.org',
            '@type'         => 'SportsClub',
            'name'          => config('seo.club_name'),
            'alternateName' => config('seo.alternate_names'),
            'description'   => config('seo.default_description'),
            'sport'         => 'Swimming',
            'url'           => url('/'),
            'logo'          => $logo,
            'image'         => $setting->about_photo_url ?: $logo,
            'telephone'     => $setting->phone,
            'email'         => $setting->email,
            'address'       => $address,
            // Kolam tempat latihan — membantu Google menghubungkan klub ini
            // dengan pencarian "Everglade Aquatic Center".
            'location'      => [
                '@type'   => 'SportsActivityLocation',
                'name'    => config('seo.venue_name'),
                'address' => $address,
            ],
            'areaServed'    => config('seo.area_served'),
            'sameAs'        => array_values(array_filter([
                $setting->instagram_url,
                $setting->facebook_url,
                $setting->youtube_url,
                $setting->tiktok_url,
            ])),
        ]);

        // JSON_HEX_TAG: cegah teks dari admin (mis. alamat) bisa "menutup"
        // tag <script> lebih awal.
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT);
    }

    /** Buang isian kosong — Google menganggap kolom kosong sebagai data tidak valid. */
    private static function clean(array $data): array
    {
        return array_filter($data, fn ($value) => $value !== null && $value !== '' && $value !== []);
    }
}