<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\ManagementMember;
use App\Models\TeamMember;
use App\Models\TeamMemberAchievement;
use App\Models\TeamMemberRecord;

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

        // Total medali digabung dari 2 sumber — pola sama persis dengan
        // accessor medal_stats di model TeamMember (dipakai halaman profil
        // per-atlet), cuma di sini dijumlah untuk SELURUH anggota tim:
        // 1. records.medal      — tiap rekor waktu = 1 medali
        // 2. achievements.total_gold/silver/bronze — medali per prestasi
        $medalsFromRecords = TeamMemberRecord::whereNotNull('medal')->count();
        $medalsFromAchievements = TeamMemberAchievement::sum('total_gold')
            + TeamMemberAchievement::sum('total_silver')
            + TeamMemberAchievement::sum('total_bronze');

        $aboutStats = [
            ['num' => $totalAthletes, 'label' => 'Atlet Aktif', 'icon' => 'fa-person-swimming'],
            ['num' => $totalCoaches, 'label' => 'Pelatih Bersertifikat', 'icon' => 'fa-user-graduate'],
            ['num' => $medalsFromRecords + $medalsFromAchievements, 'label' => 'Total Medali', 'icon' => 'fa-medal'],
        ];

        // Tim Manajemen — kalau admin belum isi data sama sekali (fresh
        // install), kirim null biar blade otomatis pakai dummy fallback-nya
        // sendiri ($managementTeam ?? [dummy]).
        $managementMembers = ManagementMember::active()->get();
        $managementTeam = $managementMembers->isNotEmpty() ? $managementMembers : null;

        return view('about.index', compact('setting', 'aboutStats', 'managementTeam'));
    }
}