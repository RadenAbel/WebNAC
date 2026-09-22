<?php

namespace App\Http\Controllers;

use App\Support\PublicCache;
use App\Models\Event;
use App\Models\SiteSetting;

class EventController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::current();
        $events = PublicCache::models('events.index', Event::class, fn () => Event::active()->get());

        return view('event.index', compact('setting', 'events'));
    }
}