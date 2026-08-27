<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRecordRequest;
use App\Models\TeamMember;
use App\Models\TeamMemberRecord;

class TeamMemberRecordController extends Controller
{
    public function store(StoreTeamMemberRecordRequest $request, TeamMember $teamMember)
    {
        $teamMember->records()->create($request->validated());

        return redirect()
            ->route('admin.team.edit', $teamMember)
            ->with('status', 'Rekor waktu berhasil ditambahkan.');
    }

    public function destroy(TeamMember $teamMember, TeamMemberRecord $record)
    {
        // Pastikan rekor ini benar milik anggota tim yang dimaksud
        // (mencegah orang lain menghapus rekor via ID sembarangan di URL)
        abort_unless($record->team_member_id === $teamMember->id, 404);

        $record->delete();

        return redirect()
            ->route('admin.team.edit', $teamMember)
            ->with('status', 'Rekor waktu berhasil dihapus.');
    }
}