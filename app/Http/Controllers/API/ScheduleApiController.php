<?php

namespace App\Http\Controllers\API;

use App\Models\Schedule;
use App\Http\Requests\ScheduleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleApiController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return response()->json($schedules);
    }

    public function store(ScheduleRequest $request)
    {
        $schedule = Schedule::create($request->validated());
        return response()->json($schedule, 201);
    }

    public function show(Schedule $schedule)
    {
        return response()->json($schedule);
    }

    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());
        return response()->json($schedule);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
