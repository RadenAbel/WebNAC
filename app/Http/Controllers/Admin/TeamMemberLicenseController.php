<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberLicenseRequest;
use App\Models\TeamMember;
use App\Models\TeamMemberLicense;
use Illuminate\Support\Facades\Storage;

class TeamMemberLicenseController extends Controller
{
    public function store(StoreTeamMemberLicenseRequest $request, TeamMember $teamMember)
    {
        $data = $request->validated();

        if ($request->hasFile('certificate_file')) {
            $data['certificate_file'] = $request->file('certificate_file')->store('licenses', 'public');
        }

        $teamMember->licenses()->create($data);

        return redirect()
            ->route('admin.team.edit', $teamMember)
            ->with('status', 'Lisensi berhasil ditambahkan.');
    }

    public function update(StoreTeamMemberLicenseRequest $request, TeamMember $teamMember, TeamMemberLicense $license)
    {
        abort_unless($license->team_member_id === $teamMember->id, 404);

        $data = $request->validated();

        if ($request->hasFile('certificate_file')) {
            if ($license->certificate_file) {
                Storage::disk('public')->delete($license->certificate_file);
            }
            $data['certificate_file'] = $request->file('certificate_file')->store('licenses', 'public');
        }

        $license->update($data);

        return redirect()
            ->route('admin.team.edit', $teamMember)
            ->with('status', 'Lisensi berhasil diperbarui.');
    }

    public function destroy(TeamMember $teamMember, TeamMemberLicense $license)
    {
        abort_unless($license->team_member_id === $teamMember->id, 404);

        if ($license->certificate_file) {
            Storage::disk('public')->delete($license->certificate_file);
        }

        $license->delete();

        return redirect()
            ->route('admin.team.edit', $teamMember)
            ->with('status', 'Lisensi berhasil dihapus.');
    }
}