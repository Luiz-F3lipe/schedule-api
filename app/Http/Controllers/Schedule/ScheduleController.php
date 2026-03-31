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
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class ScheduleController extends Controller
{
    #[OA\Get(path: '/schedules', operationId: 'listSchedules', summary: 'List schedules for the authenticated user department', security: [['sanctum' => []]], tags: ['Schedules'], responses: [new OA\Response(response: 200, description: 'Schedule list', content: new OA\JsonContent(ref: '#/components/schemas/ScheduleCollection')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden')])]
    public function index()
    {
        return ScheduleResource::collection(
            Schedule::query()
                ->with(['user', 'schedule_status'])
                ->where('department_id', Auth::user()->department_id)
                ->get()
        );
    }

    #[OA\Post(path: '/schedules', operationId: 'createSchedule', summary: 'Create a schedule', security: [['sanctum' => []]], tags: ['Schedules'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ScheduleRequest')), responses: [new OA\Response(response: 201, description: 'Schedule created', content: new OA\JsonContent(ref: '#/components/schemas/ScheduleResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();

        return ScheduleResource::make(
            Schedule::create($data)
        );
    }

    #[OA\Get(path: '/schedules/{schedule}', operationId: 'showSchedule', summary: 'Show a schedule', security: [['sanctum' => []]], tags: ['Schedules'], parameters: [new OA\Parameter(name: 'schedule', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Schedule details', content: new OA\JsonContent(ref: '#/components/schemas/ScheduleDetailResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found')])]
    public function show(Schedule $schedule)
    {
        return ScheduleDetailResource::make(
            $schedule->load(['user', 'schedule_status', 'product', 'department', 'createdBy'])
        );
    }

    #[OA\Put(path: '/schedules/{schedule}', operationId: 'updateSchedule', summary: 'Update a schedule', security: [['sanctum' => []]], tags: ['Schedules'], parameters: [new OA\Parameter(name: 'schedule', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ScheduleRequest')), responses: [new OA\Response(response: 204, description: 'Schedule updated'), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $data = $request->validated();

        $schedule->update($data);

        return response()->json([
            'message' => 'Schedule updated successfully',
        ], 204);
    }

    #[OA\Patch(path: '/schedules/{schedule}/cancel', operationId: 'cancelSchedule', summary: 'Cancel a schedule', security: [['sanctum' => []]], tags: ['Schedules'], parameters: [new OA\Parameter(name: 'schedule', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CancelScheduleRequest')), responses: [new OA\Response(response: 204, description: 'Schedule cancelled'), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function cancel(CancelScheduleRequest $request, Schedule $schedule)
    {
        $data = $request->validated();

        $schedule->update($data);

        return response()->json([
            'message' => 'Schedule cancelled successfully',
        ], 204);
    }
}
