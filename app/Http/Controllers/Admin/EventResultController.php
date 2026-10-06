<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventResultRequest;
use App\Models\Event;
use App\Models\EventResult;
use App\Models\SiteSetting;
use App\Models\TeamMember;

class EventResultController extends Controller
{
    public function store(StoreEventResultRequest $request, Event $event)
    {
        $data = $request->validated();

        if (! empty($data['team_member_id'])) {
            $member = TeamMember::find($data['team_member_id']);
            $data['athlete_name'] = $member->name;
            $data['school_name'] = ($data['school_name'] ?? null) ?: $member->school_name;
            $data['birth_date'] = $data['birth_date'] ?? $member->birth_date;
            $data['club'] = ($data['club'] ?? null) ?: (SiteSetting::current()->site_name ?? 'Nugroho Aquatic Club');
        }

        $event->results()->create($data);

        return redirect()
            ->to(route('admin.events.edit', $event) . '#hasil')
            ->withInput($request->only(['swim_event', 'age_group', 'gender']))
            ->with('status', 'Hasil ' . $data['athlete_name'] . ' berhasil ditambahkan.');
    }

    public function update(StoreEventResultRequest $request, Event $event, EventResult $result)
    {
        abort_unless($result->event_id === $event->id, 404);

        $data = $request->validated();
        $data['team_member_id'] = $data['team_member_id'] ?? null;

        if (! empty($data['team_member_id'])) {
            $member = TeamMember::find($data['team_member_id']);
            $data['athlete_name'] = $member->name;
            $data['school_name'] = ($data['school_name'] ?? null) ?: $member->school_name;
            $data['birth_date'] = ($data['birth_date'] ?? null) ?: $member->birth_date;
            $data['club'] = ($data['club'] ?? null) ?: (SiteSetting::current()->site_name ?? 'Nugroho Aquatic Club');
        }

        $result->update($data);

        return redirect()
            ->to(route('admin.events.edit', $event) . '#hasil')
            ->with('status', 'Hasil ' . $result->athlete_name . ' berhasil diperbarui.');
    }

    public function destroy(Event $event, EventResult $result)
    {
        abort_unless($result->event_id === $event->id, 404);

        $result->delete();

        return redirect()
            ->to(route('admin.events.edit', $event) . '#hasil')
            ->with('status', 'Hasil berhasil dihapus.');
    }
}
