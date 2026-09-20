<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
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

        $totalAthletes = TeamMember::active()->atlet()->count();
        $totalCoaches  = TeamMember::active()->pelatih()->count();

        // Total medali sekarang murni dari kolom `total_medals` yang diisi
        // manual per anggota tim (Rekor Waktu & Pencapaian sudah tidak
        // mencatat medali lagi, jadi tidak perlu dihitung dari situ).
        $totalMedals = TeamMember::active()->sum('total_medals');

        $aboutStats = [
            ['num' => $totalAthletes, 'label' => 'Atlet Aktif', 'icon' => 'fa-person-swimming'],
            ['num' => $totalCoaches, 'label' => 'Pelatih Bersertifikat', 'icon' => 'fa-user-graduate'],
            ['num' => $totalMedals, 'label' => 'Total Medali', 'icon' => 'fa-medal'],
        ];

        // Tim Manajemen — kalau admin belum isi data sama sekali (fresh
        // install), kirim null biar blade otomatis pakai dummy fallback-nya
        // sendiri ($managementTeam ?? [dummy]).
        $managementMembers = ManagementMember::active()->get();
        $managementTeam = $managementMembers->isNotEmpty() ? $managementMembers : null;

        return view('about.index', compact('setting', 'aboutStats', 'managementTeam'));
    }
}