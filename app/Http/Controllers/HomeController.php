<?php

namespace App\Http\Controllers;

use App\Support\PublicCache;
use App\Models\Gallery;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\TeamMember;

class HomeController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::current();

        $heroPhotos = PublicCache::remember('home.hero', fn () => Slider::active()->get()->map(function ($slider) {
            return [
                'type'                  => $slider->type,
                'photo_url'             => $slider->image_url,
                'video_embed_url'       => $slider->youtube_background_embed_url,
                'alt'                   => 'Suasana latihan Nugroho Aquatic Club',
            ];
        })->values()->all());

        $teamCounts = PublicCache::remember('home.team_counts', fn () => [
            'coaches'  => TeamMember::active()->pelatih()->count(),
            'athletes' => TeamMember::active()->atlet()->count(),
        ]);

        $heroStats = [
            ['icon' => 'fa-water',          'num' => '2',  'unit' => null, 'label' => 'Lintasan'],
            ['icon' => 'fa-ruler-combined', 'num' => '25m × 10m', 'unit' => null, 'label' => 'Ukuran Kolam Utama'],
            ['icon' => 'fa-certificate',    'num' => (string) $teamCounts['coaches'], 'unit' => null, 'label' => 'Pelatih Bersertifikat'],
            ['icon' => 'fa-users',          'num' => (string) $teamCounts['athletes'],   'unit' => null, 'label' => 'Atlet Aktif Berlatih'],
        ];

        $galleryItems = PublicCache::remember('home.gallery', fn () => Gallery::active()->get()->map(function ($item) {
            return [
                'type'            => $item->type,
                'photo_url'       => $item->image_url,
                'video_embed_url' => $item->youtube_embed_url,
                'alt'             => $item->caption,
                'caption'         => $item->caption,
            ];
        })->values()->all());

        return view('home', compact(
            'setting',
            'heroPhotos',
            'heroStats',
            'galleryItems'
        ));
    }
}
