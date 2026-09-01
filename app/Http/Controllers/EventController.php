<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::active()->get();

        return view('event.index', compact('events'));
    }

    public function show(Event $event)
    {
        abort_unless($event->is_active, 404);

        return view('event.show', compact('event'));
    }
}