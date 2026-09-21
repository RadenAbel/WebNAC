<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Schedule;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\TeamMemberAchievement;

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

            // 10 pencapaian/penghargaan terbaru — 3 tampil langsung, sisanya
            // disembunyikan dan dibuka lewat tombol "Lihat Selengkapnya"
            // (kartu terbuka turun, tidak pindah halaman).
            'recentAchievements' => TeamMemberAchievement::with('teamMember')
                                    ->latest('year')
                                    ->latest('id')
                                    ->take(10)
                                    ->get(),
        ]);
    }
}