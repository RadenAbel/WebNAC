<?php

namespace App\Http\Controllers;

use App\Support\PublicCache;
use App\Models\SiteSetting;
use App\Models\Facility;
use App\Models\ManagementMember;
use App\Models\TeamMember;

class AboutController extends Controller
{
    /**
     * Halaman "Tentang Kami".
     */
    public function index()
    {
        $setting = SiteSetting::current();

        $totals = PublicCache::remember('about.totals', fn () => [
            'athletes' => TeamMember::active()->atlet()->count(),
            'coaches'  => TeamMember::active()->pelatih()->count(),
            'medals'   => (int) TeamMember::active()->sum('total_medals'),
        ]);
        $totalAthletes = $totals['athletes'];
        $totalCoaches  = $totals['coaches'];

        // Total medali sekarang murni dari kolom `total_medals` yang diisi
        // manual per anggota tim (Rekor Waktu & Pencapaian sudah tidak
        // mencatat medali lagi, jadi tidak perlu dihitung dari situ).
        $totalMedals = $totals['medals'];

        $aboutStats = [
            ['num' => $totalAthletes, 'label' => 'Atlet Aktif', 'icon' => 'fa-person-swimming'],
            ['num' => $totalCoaches, 'label' => 'Pelatih Bersertifikat', 'icon' => 'fa-user-graduate'],
            ['num' => $totalMedals, 'label' => 'Total Medali', 'icon' => 'fa-medal'],
        ];

        // Tim Manajemen — kalau admin belum isi data sama sekali (fresh
        // install), kirim null biar blade otomatis pakai dummy fallback-nya
        // sendiri ($managementTeam ?? [dummy]).
        $managementMembers = PublicCache::models('about.management', ManagementMember::class, fn () => ManagementMember::active()->get());
        $managementTeam = $managementMembers->isNotEmpty() ? $managementMembers : null;

        // Fasilitas (dikelola di Admin → Fasilitas). Bagian Fasilitas di
        // halaman hanya muncul kalau ada minimal satu fasilitas aktif.
        $facilities = PublicCache::models('about.facilities', Facility::class, fn () => Facility::active()->ordered()->get());

        return view('about.index', compact('setting', 'aboutStats', 'managementTeam', 'facilities'));
    }
}