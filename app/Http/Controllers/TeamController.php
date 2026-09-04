<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;

class TeamController extends Controller
{
    /**
     * Tampilkan halaman "Our Team" — gabungan pelatih & atlit.
     */
    public function index()
    {
        $coaches  = TeamMember::active()->pelatih()->get();
        $athletes = TeamMember::active()->atlet()->get();

        return view('team.index', compact('coaches', 'athletes'));
    }

    /**
     * Halaman profil detail satu anggota tim.
     */
    public function show(TeamMember $teamMember)
    {
        abort_unless($teamMember->is_active, 404);

        // Load relasi sekali di awal — dipakai berulang kali oleh accessor
        // medal_stats & personal_bests di model (menghindari N+1 query).
        $teamMember->load(['records', 'achievements']);

        // 'achievements' adalah nama RELASI di model (juga dipakai admin CRUD),
        // tapi halaman profil publik ini butuh bentuknya sebagai array
        // sederhana (title, year) — bukan objek Eloquent penuh. Di-override
        // KHUSUS untuk kebutuhan tampilan; data asli di database tidak berubah.
        $teamMember->setAttribute(
            'achievements',
            $teamMember->achievements->map(fn ($achievement) => [
                'title'        => $achievement->title,
                'year'         => $achievement->year,
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