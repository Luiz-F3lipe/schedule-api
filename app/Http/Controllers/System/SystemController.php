<?php

declare(strict_types = 1);

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\StoreSystemRequest;
use App\Http\Resources\System\SystemResource;
use App\Models\System;
use OpenApi\Attributes as OA;

class SystemController extends Controller
{
    #[OA\Get(path: '/systems', operationId: 'listSystems', summary: 'List systems', security: [['sanctum' => []]], tags: ['Systems'], responses: [new OA\Response(response: 200, description: 'System list', content: new OA\JsonContent(ref: '#/components/schemas/SystemCollection')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden')])]
    public function index()
    {
        return SystemResource::collection(
            System::all()
        );
    }

    #[OA\Post(path: '/systems', operationId: 'createSystem', summary: 'Create a system', security: [['sanctum' => []]], tags: ['Systems'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/SystemRequest')), responses: [new OA\Response(response: 201, description: 'System created', content: new OA\JsonContent(ref: '#/components/schemas/SystemResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function store(StoreSystemRequest $request)
    {
        $system = $request->validated();

        return SystemResource::make(
            System::create($system)
        );
    }

    #[OA\Get(path: '/systems/{system}', operationId: 'showSystem', summary: 'Show a system', security: [['sanctum' => []]], tags: ['Systems'], parameters: [new OA\Parameter(name: 'system', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'System details', content: new OA\JsonContent(ref: '#/components/schemas/SystemResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found')])]
    public function show(System $system)
    {
        return SystemResource::make($system);
    }

    #[OA\Put(path: '/systems/{system}', operationId: 'updateSystem', summary: 'Update a system', security: [['sanctum' => []]], tags: ['Systems'], parameters: [new OA\Parameter(name: 'system', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/SystemRequest')), responses: [new OA\Response(response: 200, description: 'System updated', content: new OA\JsonContent(ref: '#/components/schemas/SystemResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function update(StoreSystemRequest $request, System $system)
    {
        $data = $request->validated();

        $system->update($data);

        return SystemResource::make($system);
    }
}
