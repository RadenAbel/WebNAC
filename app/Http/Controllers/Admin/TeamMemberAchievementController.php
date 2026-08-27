<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberAchievementRequest;
use App\Models\TeamMember;
use App\Models\TeamMemberAchievement;

class TeamMemberAchievementController extends Controller
{
    public function store(StoreTeamMemberAchievementRequest $request, TeamMember $teamMember)
    {
        $teamMember->achievements()->create($request->validated());

        return redirect()
            ->route('admin.team.edit', $teamMember)
            ->with('status', 'Pencapaian berhasil ditambahkan.');
    }

    public function destroy(TeamMember $teamMember, TeamMemberAchievement $achievement)
    {
        abort_unless($achievement->team_member_id === $teamMember->id, 404);

        $achievement->delete();

        return redirect()
            ->route('admin.team.edit', $teamMember)
            ->with('status', 'Pencapaian berhasil dihapus.');
    }
}