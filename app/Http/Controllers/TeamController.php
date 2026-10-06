<?php

namespace App\Http\Controllers;

use App\Support\PublicCache;
use App\Models\SiteSetting;
use App\Models\TeamMember;

class TeamController extends Controller
{
    public function athletes()
    {
        $setting = SiteSetting::current();
        $athletes = PublicCache::models('team.athletes', TeamMember::class, fn () => TeamMember::active()->atlet()->get());

        return view('team.athletes', compact('setting', 'athletes'));
    }

    public function coaches()
    {
        $setting = SiteSetting::current();
        $coaches = PublicCache::models('team.coaches', TeamMember::class, fn () => TeamMember::active()->pelatih()->get());

        return view('team.coaches', compact('setting', 'coaches'));
    }

    public function show(string $slug)
    {
        $teamMember = TeamMember::where('slug', $slug)->first();

        if (! $teamMember && ctype_digit($slug)) {
            $legacy = TeamMember::find($slug);

            if ($legacy && $legacy->is_active && $legacy->slug) {
                return redirect()->route('team.show', $legacy->slug, 301);
            }
        }

        abort_unless($teamMember && $teamMember->is_active, 404);

        $teamMember->load(['records', 'achievements', 'licenses']);

        $teamMember->setAttribute(
            'achievements',
            $teamMember->achievements->map(fn ($achievement) => [
                'title'        => $achievement->title,
                'year'         => $achievement->year,
                'event_date'   => $achievement->event_date_label,
                'description'  => $achievement->description,
                'country_code' => $achievement->country ? strtolower($achievement->country) : null,
                'country'      => $achievement->country_name,
            ])->values()->all()
        );

        return view('team.show', [
            'member' => $teamMember,
        ]);
    }
}
