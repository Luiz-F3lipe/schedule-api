<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Http\Resources\Department\DepartmentResource;
use App\Models\Department;
use OpenApi\Attributes as OA;

class DepartmentController extends Controller
{
    #[OA\Get(path: '/departments', operationId: 'listDepartments', summary: 'List departments', security: [['sanctum' => []]], tags: ['Departments'], responses: [new OA\Response(response: 200, description: 'Department list', content: new OA\JsonContent(ref: '#/components/schemas/DepartmentCollection')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden')])]
    public function index()
    {
        return DepartmentResource::collection(
            Department::all()
        );
    }

    #[OA\Get(path: '/departments/{department}', operationId: 'showDepartment', summary: 'Show a department', security: [['sanctum' => []]], tags: ['Departments'], parameters: [new OA\Parameter(name: 'department', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Department details', content: new OA\JsonContent(ref: '#/components/schemas/DepartmentResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found')])]
    public function show(Department $department)
    {
        return DepartmentResource::make($department);
    }

    #[OA\Post(path: '/departments', operationId: 'createDepartment', summary: 'Create a department', security: [['sanctum' => []]], tags: ['Departments'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/DepartmentRequest')), responses: [new OA\Response(response: 201, description: 'Department created', content: new OA\JsonContent(ref: '#/components/schemas/DepartmentResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function store(StoreDepartmentRequest $request)
    {
        $data = $request->validated();

        $department = Department::create($data);

        return DepartmentResource::make($department);
    }

    #[OA\Put(path: '/departments/{department}', operationId: 'updateDepartment', summary: 'Update a department', security: [['sanctum' => []]], tags: ['Departments'], parameters: [new OA\Parameter(name: 'department', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/DepartmentRequest')), responses: [new OA\Response(response: 200, description: 'Department updated', content: new OA\JsonContent(ref: '#/components/schemas/DepartmentResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $data = $request->validated();

        $department->update($data);

        return DepartmentResource::make($department);
    }
}
