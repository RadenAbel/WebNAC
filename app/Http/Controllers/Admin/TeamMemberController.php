<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Http\Requests\Admin\UpdateTeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    /**
     * Daftar semua anggota tim, bisa difilter per peran lewat ?role=pelatih|atlet
     */
    public function index(Request $request)
    {
        $query = TeamMember::query()->orderBy('sort_order')->orderBy('name');

        if ($request->filled('role') && in_array($request->role, ['pelatih', 'atlet'])) {
            $query->where('role', $request->role);
        }

        $members = $query->paginate(10)->withQueryString();

        return view('admin.team.index', [
            'members'    => $members,
            'activeRole' => $request->get('role', 'semua'),
        ]);
    }

    public function create()
    {
        return view('admin.team.create', [
            'member' => new TeamMember(),
        ]);
    }

    public function store(StoreTeamMemberRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $member = TeamMember::create($data);

        return redirect()
            ->route('admin.team.edit', $member)
            ->with('status', "Anggota tim \"{$member->name}\" berhasil ditambahkan. Sekarang Anda bisa menambahkan rekor & pencapaiannya di bawah.");
    }

    public function edit(TeamMember $teamMember)
    {
        // Load relasi rekor & pencapaian sekaligus, biar tidak N+1 query di view
        $teamMember->load(['records', 'achievements']);

        return view('admin.team.edit', [
            'member' => $teamMember,
        ]);
    }

    public function update(UpdateTeamMemberRequest $request, TeamMember $teamMember)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            // Hapus foto lama dari storage supaya tidak menumpuk file yatim
            if ($teamMember->photo) {
                Storage::disk('public')->delete($teamMember->photo);
            }
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $teamMember->update($data);

        return redirect()
            ->route('admin.team.edit', $teamMember)
            ->with('status', 'Data berhasil diperbarui.');
    }

    public function destroy(TeamMember $teamMember)
    {
        // Hapus foto dari storage. Rekor & pencapaian ikut terhapus otomatis
        // lewat cascadeOnDelete() di migration (tidak perlu dihapus manual).
        if ($teamMember->photo) {
            Storage::disk('public')->delete($teamMember->photo);
        }

        $name = $teamMember->name;
        $teamMember->delete();

        return redirect()
            ->route('admin.team.index')
            ->with('status', "Anggota tim \"{$name}\" berhasil dihapus.");
    }
}