<?php

namespace App\Http\Controllers\Web;

use App\Models\Schedule;
use App\Http\Requests\ScheduleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return view('admin.schedule-management.index', compact('schedules'));
    }

    public function create()
    {
        return view('admin.schedule-management.create');
    }

    public function store(ScheduleRequest $request)
    {
        Schedule::create($request->validated());
        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        return view('admin.schedule-management.details', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.schedule-management.update', compact('schedule'));
    }

    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());
        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
