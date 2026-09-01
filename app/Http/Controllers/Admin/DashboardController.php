<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Schedule;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\TeamMemberAchievement;
use App\Models\TeamMemberRecord;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalTeam'      => TeamMember::count(),
            'totalCoaches'   => TeamMember::pelatih()->count(),
            'totalAthletes'  => TeamMember::atlet()->count(),
            'totalSliders'   => Slider::count(),
            'totalGalleries' => Gallery::count(),
            'totalSchedules' => Schedule::count(),

            // ============ Statistik Kejuaraan ============
            // Dihitung otomatis dari rekor waktu (team_member_records) &
            // pencapaian (team_member_achievements) yang diinput admin di
            // halaman Tim — bukan angka manual, jadi selalu akurat.
            'totalGold'        => TeamMemberRecord::where('medal', 'Emas')->count(),
            'totalSilver'      => TeamMemberRecord::where('medal', 'Perak')->count(),
            'totalBronze'      => TeamMemberRecord::where('medal', 'Perunggu')->count(),
            'totalCompetitions'=> TeamMemberRecord::whereNotNull('competition')
                                    ->distinct()
                                    ->count('competition'),

            // 5 pencapaian/penghargaan terbaru dari seluruh anggota tim,
            // dilengkapi nama pemiliknya untuk ditampilkan di dashboard.
            'recentAchievements' => TeamMemberAchievement::with('teamMember')
                                    ->latest('year')
                                    ->latest('id')
                                    ->take(5)
                                    ->get(),

            // Tren jumlah medali per tahun (untuk bar chart) — hanya rekor
            // yang tanggalnya diisi admin yang dihitung.
            'medalsByYear' => TeamMemberRecord::whereNotNull('record_date')
                                    ->whereNotNull('medal')
                                    ->selectRaw('YEAR(record_date) as year, COUNT(*) as total')
                                    ->groupBy('year')
                                    ->orderBy('year')
                                    ->pluck('total', 'year'),
        ]);
    }
}