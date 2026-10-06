<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventResult;
use App\Models\SiteSetting;
use App\Support\PublicCache;

class EventController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::current();
        $events = PublicCache::models('events.index', Event::class, fn () => Event::active()->get());

        return view('event.index', compact('setting', 'events'));
    }

    public function show(Event $event)
    {
        abort_unless($event->is_active, 404);

        $setting = SiteSetting::current();

        $results = $event->results()
            ->with('teamMember:id,name,slug,is_active,school_name')
            ->get();

        $swimOrder = array_flip(collect(config('swim_events'))->flatten()->all());
        $genderOrder = ['putra' => 0, 'putri' => 1, 'campuran' => 2];

        $groups = $results
            ->groupBy(fn ($r) => $r->swim_event . '|' . $r->age_group . '|' . $r->gender)
            ->map(function ($rows) {
                $first = $rows->first();
                $rows = $rows->sortBy(fn ($r) => [$r->rank === null ? 1 : 0, $r->rank ?? 0, $r->athlete_name])->values();

                EventResult::assignGapLabels($rows);

                return (object) [
                    'swim_event'   => $first->swim_event,
                    'age_group'    => $first->age_group,
                    'gender'       => $first->gender,
                    'gender_label' => $first->gender_label,
                    'rows'         => $rows,
                ];
            })
            ->sortBy(fn ($g) => [
                $swimOrder[$g->swim_event] ?? 999,
                $g->swim_event,
                (string) $g->age_group,
                $genderOrder[$g->gender] ?? 9,
            ])
            ->values();

        $filters = [
            'age_groups' => $results->pluck('age_group')->filter()->unique()->sort(SORT_NATURAL)->values(),
            'genders'    => EventResult::GENDERS,
            'swim_events'=> $groups->pluck('swim_event')->unique()->values(),
        ];

        return view('event.show', compact('setting', 'event', 'groups', 'filters'));
    }
}
