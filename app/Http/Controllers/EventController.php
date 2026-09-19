<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\SiteSetting;

class EventController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::current();
        $events = Event::active()->get();

        return view('event.index', compact('setting', 'events'));
    }

    public function show(Event $event)
    {
        abort_unless($event->is_active, 404);

        return view('event.show', compact('event'));
    }
}