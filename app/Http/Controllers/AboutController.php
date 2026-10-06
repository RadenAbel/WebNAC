<?php

namespace App\Http\Controllers;

use App\Support\PublicCache;
use App\Models\SiteSetting;
use App\Models\Facility;
use App\Models\ManagementMember;
use App\Models\PricingPlan;
use App\Models\Schedule;
use App\Models\TeamMember;

class AboutController extends Controller
{
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

        $totalMedals = $totals['medals'];

        $aboutStats = [
            ['num' => $totalAthletes, 'label' => 'Atlet Aktif', 'icon' => 'fa-person-swimming'],
            ['num' => $totalCoaches, 'label' => 'Pelatih Bersertifikat', 'icon' => 'fa-user-graduate'],
            ['num' => $totalMedals, 'label' => 'Total Medali', 'icon' => 'fa-medal'],
        ];

        $managementTeam = PublicCache::models('about.management', ManagementMember::class, fn () => ManagementMember::active()->get());

        $facilities = PublicCache::models('about.facilities', Facility::class, fn () => Facility::active()->ordered()->get());

        $pricingPlans = PublicCache::models('about.pricing', PricingPlan::class, fn () => PricingPlan::active()->ordered()->get());
        $schedules    = PublicCache::models('about.schedules', Schedule::class, fn () => Schedule::active()->get());

        return view('about.index', compact('setting', 'aboutStats', 'managementTeam', 'facilities', 'pricingPlans', 'schedules'));
    }
}
