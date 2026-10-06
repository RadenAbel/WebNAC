<?php

namespace App\Http\Controllers\Admin;

use App\Support\ImageOptimizer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Models\Event;
use App\Models\EventResult;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('sort_order')->orderByDesc('event_date')->paginate(9);

        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        return view('admin.event.create', [
            'event' => new Event(),
        ]);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['photo'] = ImageOptimizer::store($request->file('photo'), 'events');

        $event = Event::create($data);

        return redirect()
            ->to(route('admin.events.edit', $event) . '#hasil')
            ->with('status', 'Kejuaraan berhasil ditambahkan. Sekarang isi hasil per nomor lomba di bawah.');
    }

    public function edit(Event $event)
    {
        $event->load(['results' => fn ($q) => $q->orderBy('swim_event')->orderBy('age_group')->orderBy('gender')
            ->orderByRaw('`rank` IS NULL')->orderBy('rank')]);

        $athletes = TeamMember::atlet()->orderBy('name')->get(['id', 'name', 'birth_date']);

        $ageGroups = collect(['KU 1', 'KU 2', 'KU 3', 'KU 4', 'KU 5', 'Senior', 'Master', 'Umum'])
            ->merge(EventResult::query()->whereNotNull('age_group')->distinct()->pluck('age_group'))
            ->unique()->values();

        return view('admin.event.edit', compact('event', 'athletes', 'ageGroups'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($event->photo) {
                Storage::disk('public')->delete($event->photo);
            }
            $data['photo'] = ImageOptimizer::store($request->file('photo'), 'events');
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Hasil Pertandingan berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->photo) {
            Storage::disk('public')->delete($event->photo);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Hasil Pertandingan berhasil dihapus.');
    }
}
