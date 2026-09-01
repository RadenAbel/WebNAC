<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Models\Event;
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
        $data['photo'] = $request->file('photo')->store('events', 'public');
        $data['pdf_report'] = $request->file('pdf_report')->store('events/reports', 'public');

        Event::create($data);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Acara berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('admin.event.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($event->photo) {
                Storage::disk('public')->delete($event->photo);
            }
            $data['photo'] = $request->file('photo')->store('events', 'public');
        }

        if ($request->hasFile('pdf_report')) {
            if ($event->pdf_report) {
                Storage::disk('public')->delete($event->pdf_report);
            }
            $data['pdf_report'] = $request->file('pdf_report')->store('events/reports', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Acara berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->photo) {
            Storage::disk('public')->delete($event->photo);
        }
        if ($event->pdf_report) {
            Storage::disk('public')->delete($event->pdf_report);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Acara berhasil dihapus.');
    }
}