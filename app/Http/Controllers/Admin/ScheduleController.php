<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreScheduleRequest;
use App\Http\Requests\Admin\UpdateScheduleRequest;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::orderBy('sort_order')->get();

        return view('admin.schedule.index', compact('schedules'));
    }

    public function create()
    {
        return view('admin.schedule.create', [
            'schedule' => new Schedule(),
        ]);
    }

    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        Schedule::create($data);

        return redirect()
            ->route('admin.schedules.index')
            ->with('status', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.schedule.edit', compact('schedule'));
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $schedule->update($data);

        return redirect()
            ->route('admin.schedules.index')
            ->with('status', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()
            ->route('admin.schedules.index')
            ->with('status', 'Jadwal berhasil dihapus.');
    }
}