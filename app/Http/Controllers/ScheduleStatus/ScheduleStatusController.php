<?php

declare(strict_types = 1);

namespace App\Http\Controllers\ScheduleStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleStatus\StoreScheduleStatusRequest;
use App\Http\Requests\ScheduleStatus\UpdateScheduleStatusRequest;
use App\Http\Resources\ScheduleStatus\ScheduleStatusResource;
use App\Models\ScheduleStatus;

class ScheduleStatusController extends Controller
{
    public function index()
    {
        return ScheduleStatusResource::collection(
            ScheduleStatus::all()
        );
    }

    public function store(StoreScheduleStatusRequest $request)
    {
        $data = $request->validated();

        return ScheduleStatusResource::make(
            ScheduleStatus::create($data)
        );
    }

    public function show(ScheduleStatus $scheduleStatus)
    {
        return ScheduleStatusResource::make($scheduleStatus);
    }

    public function update(UpdateScheduleStatusRequest $request, ScheduleStatus $scheduleStatus)
    {
        $data = $request->validated();

        $scheduleStatus->update($data);

        return ScheduleStatusResource::make($scheduleStatus);
    }
}
