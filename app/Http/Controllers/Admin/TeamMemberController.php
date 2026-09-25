<?php

namespace App\Http\Controllers\Admin;

use App\Support\ImageOptimizer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Http\Requests\Admin\UpdateTeamMemberRequest;
use App\Models\TeamMember;
use App\Support\SocialLinkHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    /**
     * Data Atlet dan data Pelatih dikelola terpisah (menu dropdown di
     * sidebar). Peran dibaca dari ?role=atlet|pelatih, bawaannya atlet.
     */
    private function roleFrom(Request $request): string
    {
        return $request->get('role') === 'pelatih' ? 'pelatih' : 'atlet';
    }

    public function index(Request $request)
    {
        $role = $this->roleFrom($request);

        $members = TeamMember::query()
            ->where('role', $role)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.team.index', [
            'members'    => $members,
            'activeRole' => $role,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.team.create', [
            'member' => new TeamMember(['role' => $this->roleFrom($request)]),
        ]);
    }

    /**
     * Field yang hanya berlaku untuk atlet (Kategori, Asal Sekolah)
     * dikosongkan kalau datanya milik pelatih.
     */
    private function normalizeByRole(array $data): array
    {
        if (($data['role'] ?? null) === 'pelatih') {
            $data['category'] = null;
            $data['school_name'] = null;
        }

        return $data;
    }

    public function store(StoreTeamMemberRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['photo_is_cutout'] = $request->boolean('photo_is_cutout');
        $data['swim_style'] = !empty($data['swim_style']) ? implode(', ', $data['swim_style']) : null;
        $data['instagram_url'] = SocialLinkHelper::toFullUrl($data['instagram_url'] ?? null, 'instagram');
        $data['facebook_url']  = SocialLinkHelper::toFullUrl($data['facebook_url'] ?? null, 'facebook');
        $data['tiktok_url']    = SocialLinkHelper::toFullUrl($data['tiktok_url'] ?? null, 'tiktok');

        if ($request->hasFile('photo')) {
            $data['photo'] = ImageOptimizer::store($request->file('photo'), 'team');
        }

        $member = TeamMember::create($this->normalizeByRole($data));

        return redirect()
            ->route('admin.team.edit', $member)
            ->with('status', "Anggota tim \"{$member->name}\" berhasil ditambahkan. Sekarang Anda bisa menambahkan rekor & pencapaiannya di bawah.");
    }

    public function edit(TeamMember $teamMember)
    {
        // Load relasi rekor, pencapaian, & lisensi sekaligus, biar tidak N+1 query di view
        $teamMember->load(['records', 'achievements', 'licenses']);

        return view('admin.team.edit', [
            'member' => $teamMember,
        ]);
    }

    public function update(UpdateTeamMemberRequest $request, TeamMember $teamMember)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['photo_is_cutout'] = $request->boolean('photo_is_cutout');
        $data['swim_style'] = !empty($data['swim_style']) ? implode(', ', $data['swim_style']) : null;
        $data['instagram_url'] = SocialLinkHelper::toFullUrl($data['instagram_url'] ?? null, 'instagram');
        $data['facebook_url']  = SocialLinkHelper::toFullUrl($data['facebook_url'] ?? null, 'facebook');
        $data['tiktok_url']    = SocialLinkHelper::toFullUrl($data['tiktok_url'] ?? null, 'tiktok');

        if ($request->hasFile('photo')) {
            // Hapus foto lama dari storage supaya tidak menumpuk file yatim
            if ($teamMember->photo) {
                Storage::disk('public')->delete($teamMember->photo);
            }
            $data['photo'] = ImageOptimizer::store($request->file('photo'), 'team');
        }

        $teamMember->update($this->normalizeByRole($data));

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
        $role = $teamMember->role;
        $teamMember->delete();

        return redirect()
            ->route('admin.team.index', ['role' => $role])
            ->with('status', "Anggota tim \"{$name}\" berhasil dihapus.");
    }
}