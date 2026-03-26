<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\CancelScheduleRequest;
use App\Http\Requests\Schedule\StoreScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Http\Resources\Schedule\ScheduleDetailResource;
use App\Http\Resources\Schedule\ScheduleResource;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        return ScheduleResource::collection(
            Schedule::query()
                ->with(['user', 'schedule_status'])
                ->get()
        );
    }

    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();

        return ScheduleResource::make(
            Schedule::create($data)
        );
    }

    public function show(Schedule $schedule)
    {
        return ScheduleDetailResource::make(
            $schedule->load(['user', 'schedule_status', 'product', 'department', 'createdBy'])
        );
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $data = $request->validated();

        $schedule->update($data);

        return response()->json([
            'message' => 'Schedule updated successfully',
        ], 204);
    }

    public function cancel(CancelScheduleRequest $request, Schedule $schedule)
    {
        $data = $request->validated();

        $schedule->update($data);

        return response()->json([
            'message' => 'Schedule cancelled successfully',
        ], 204);
    }
}
