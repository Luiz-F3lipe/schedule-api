<?php

declare(strict_types = 1);

namespace App\Http\Controllers\ScheduleStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleStatus\StoreScheduleStatusRequest;
use App\Http\Requests\ScheduleStatus\UpdateScheduleStatusRequest;
use App\Http\Resources\ScheduleStatus\ScheduleStatusResource;
use App\Models\ScheduleStatus;
use OpenApi\Attributes as OA;

class ScheduleStatusController extends Controller
{
    #[OA\Get(path: '/schedule-status', operationId: 'listScheduleStatuses', summary: 'List schedule statuses', security: [['sanctum' => []]], tags: ['Schedule Status'], responses: [new OA\Response(response: 200, description: 'Schedule status list', content: new OA\JsonContent(ref: '#/components/schemas/ScheduleStatusCollection')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden')])]
    public function index()
    {
        return ScheduleStatusResource::collection(
            ScheduleStatus::all()
        );
    }

    #[OA\Post(path: '/schedule-status', operationId: 'createScheduleStatus', summary: 'Create a schedule status', security: [['sanctum' => []]], tags: ['Schedule Status'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ScheduleStatusRequest')), responses: [new OA\Response(response: 201, description: 'Schedule status created', content: new OA\JsonContent(ref: '#/components/schemas/ScheduleStatusResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function store(StoreScheduleStatusRequest $request)
    {
        $data = $request->validated();

        return ScheduleStatusResource::make(
            ScheduleStatus::create($data)
        );
    }

    #[OA\Get(path: '/schedule-status/{scheduleStatus}', operationId: 'showScheduleStatus', summary: 'Show a schedule status', security: [['sanctum' => []]], tags: ['Schedule Status'], parameters: [new OA\Parameter(name: 'scheduleStatus', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Schedule status details', content: new OA\JsonContent(ref: '#/components/schemas/ScheduleStatusResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found')])]
    public function show(ScheduleStatus $scheduleStatus)
    {
        return ScheduleStatusResource::make($scheduleStatus);
    }

    #[OA\Put(path: '/schedule-status/{scheduleStatus}', operationId: 'updateScheduleStatus', summary: 'Update a schedule status', security: [['sanctum' => []]], tags: ['Schedule Status'], parameters: [new OA\Parameter(name: 'scheduleStatus', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ScheduleStatusRequest')), responses: [new OA\Response(response: 200, description: 'Schedule status updated', content: new OA\JsonContent(ref: '#/components/schemas/ScheduleStatusResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function update(UpdateScheduleStatusRequest $request, ScheduleStatus $scheduleStatus)
    {
        $data = $request->validated();

        $scheduleStatus->update($data);

        return ScheduleStatusResource::make($scheduleStatus);
    }
}
