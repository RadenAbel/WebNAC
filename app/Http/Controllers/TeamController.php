<?php

namespace App\Http\Controllers;

use App\Support\PublicCache;
use App\Models\SiteSetting;
use App\Models\TeamMember;

class TeamController extends Controller
{
    /**
     * Halaman "Our Team" — Atlet saja.
     */
    public function athletes()
    {
        $setting = SiteSetting::current();
        $athletes = PublicCache::models('team.athletes', TeamMember::class, fn () => TeamMember::active()->atlet()->get());

        return view('team.athletes', compact('setting', 'athletes'));
    }

    /**
     * Halaman "Our Team" — Pelatih saja.
     */
    public function coaches()
    {
        $setting = SiteSetting::current();
        $coaches = PublicCache::models('team.coaches', TeamMember::class, fn () => TeamMember::active()->pelatih()->get());

        return view('team.coaches', compact('setting', 'coaches'));
    }

    /**
     * Halaman profil detail satu anggota tim (dipakai baik untuk atlet
     * maupun pelatih — kontennya menyesuaikan lewat $member->role di view).
     */
    public function show(TeamMember $teamMember)
    {
        abort_unless($teamMember->is_active, 404);

        // Load relasi sekali di awal — dipakai berulang kali oleh accessor
        // medal_stats & personal_bests di model (menghindari N+1 query).
        // 'licenses' cuma relevan buat pelatih, tapi tetap di-load di sini
        // supaya kode-nya sama untuk kedua role (query-nya murah, cuma
        // kosong kalau atlet).
        $teamMember->load(['records', 'achievements', 'licenses']);

        // 'achievements' adalah nama RELASI di model (juga dipakai admin CRUD),
        // tapi halaman profil publik ini butuh bentuknya sebagai array
        // sederhana (title, year) — bukan objek Eloquent penuh. Di-override
        // KHUSUS untuk kebutuhan tampilan; data asli di database tidak berubah.
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