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
        // Ambil pelatih & atlit terpisah (untuk kebutuhan tampilan per section),
        // tapi tetap dari satu tabel team_members.
        $coaches  = TeamMember::active()->pelatih()->get();
        $athletes = TeamMember::active()->atlet()->get();

        return view('team.index', compact('coaches', 'athletes'));
    }
    
    public function show(TeamMember $teamMember)
    {
        // Anggota lain dengan role yang sama, untuk rekomendasi di halaman detail.
        $related = TeamMember::where('role', $teamMember->role)
            ->where('id', '!=', $teamMember->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();
 
        return view('team.show', [
            'member'  => $teamMember,
            'related' => $related,
        ]);
    }
}