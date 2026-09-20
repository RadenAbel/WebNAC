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
            // Total medali sekarang murni dari kolom `total_medals` yang
            // diisi manual per anggota tim (Rekor Waktu & Pencapaian tidak
            // lagi mencatat medali sama sekali).
            'totalMedals'      => TeamMember::sum('total_medals'),
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
        ]);
    }
}