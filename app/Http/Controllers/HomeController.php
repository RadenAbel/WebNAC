<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Schedule;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\TeamMember;

class HomeController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::current();

        // ============ HERO: foto slider ============
        // Slider di admin dipetakan ke bentuk yang dipakai carousel foto hero.
        // Kalau admin belum upload slider sama sekali, $heroPhotos otomatis
        // jadi array kosong — carousel tetap jalan, cuma tampil slide statistik saja.
        $heroPhotos = Slider::active()->get()->map(function ($slider) {
            return [
                'photo_url' => $slider->image_url,
                'alt'       => $slider->title,
                'caption'   => $slider->title,
            ];
        })->values()->all();

        // ============ HERO: statistik ============
        // Jumlah pelatih & atlet diambil LANGSUNG dari data asli (auto update
        // begitu admin nambah/hapus anggota tim). Lintasan & panjang kolam
        // belum ada menu admin-nya, jadi masih nilai tetap di sini — kalau
        // suatu saat berubah, cukup edit 2 baris ini.
        $heroStats = [
            ['icon' => 'fa-water',          'num' => '2',  'unit' => null, 'label' => 'Lintasan'],
            ['icon' => 'fa-ruler-combined', 'num' => '50', 'unit' => 'm',  'label' => 'Panjang Kolam Utama'],
            ['icon' => 'fa-certificate',    'num' => (string) TeamMember::active()->pelatih()->count(), 'unit' => null, 'label' => 'Pelatih Bersertifikat'],
            ['icon' => 'fa-users',          'num' => (string) TeamMember::active()->atlet()->count(),   'unit' => null, 'label' => 'Atlet Aktif Berlatih'],
        ];

        // ============ GALERI ============
        $galleryItems = Gallery::active()->get()->map(function ($item) {
            return [
                'photo_url' => $item->image_url,
                'alt'       => $item->caption,
                'caption'   => $item->caption,
            ];
        })->values()->all();

        // ============ JADWAL ============
        $schedules = Schedule::active()->get();

        return view('home', compact(
            'setting',
            'heroPhotos',
            'heroStats',
            'galleryItems',
            'schedules'
        ));
    }
}