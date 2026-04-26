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
        $schedules = Schedule::accessibleBy(auth()->user())->get();
        return response()->json($schedules);
    }

    public function store(ScheduleRequest $request, \App\Services\ScheduleService $scheduleService)
    {
        $schedule = $scheduleService->createSchedule($request->validated(), auth()->user());
        return response()->json($schedule, 201);
    }

    public function show(Schedule $schedule)
    {
        return response()->json($schedule);
    }

    public function update(ScheduleRequest $request, Schedule $schedule, \App\Services\ScheduleService $scheduleService)
    {
        $scheduleService->updateSchedule($schedule, $request->validated());
        return response()->json($schedule);
    }

    public function destroy(Schedule $schedule, \App\Services\ScheduleService $scheduleService)
    {
        $scheduleService->deleteSchedule($schedule);
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
