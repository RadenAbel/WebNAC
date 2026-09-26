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

        // ============ HERO: foto/video slider ============
        // Slider di admin dipetakan ke bentuk yang dipakai carousel hero.
        // Kalau admin belum upload slider sama sekali, $heroPhotos otomatis
        // jadi array kosong — carousel tetap jalan, cuma tampil slide statistik saja.
        $heroPhotos = PublicCache::remember('home.hero', fn () => Slider::active()->get()->map(function ($slider) {
            return [
                'type'                  => $slider->type,
                'photo_url'             => $slider->image_url,
                'video_embed_url'       => $slider->youtube_background_embed_url,
                'alt'                   => 'Suasana latihan Nugroho Aquatic Club',
            ];
        })->values()->all());

        // ============ HERO: statistik ============
        // Jumlah pelatih & atlet diambil LANGSUNG dari data asli (auto update
        // begitu admin nambah/hapus anggota tim). Lintasan & panjang kolam
        // belum ada menu admin-nya, jadi masih nilai tetap di sini — kalau
        // suatu saat berubah, cukup edit 2 baris ini.
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

        // ============ GALERI ============
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