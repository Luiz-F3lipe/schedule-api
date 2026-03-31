<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\AssignPermissionRequest;
use App\Http\Requests\Permission\RemovePermissionRequest;
use App\Http\Requests\Permission\SyncPermissionRequest;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PermissionController extends Controller
{
    /**
     * List all permissions
     */
    #[OA\Get(path: '/permissions', operationId: 'listPermissions', summary: 'List all permissions grouped by resource', security: [['sanctum' => []]], tags: ['Permissions'], responses: [new OA\Response(response: 200, description: 'Permissions grouped by resource', content: new OA\JsonContent(ref: '#/components/schemas/PermissionsGroupedResponse')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden')])]
    public function index(): JsonResponse
    {
        $permissions = Permission::all()->groupBy('resource');

        return response()->json([
            'success' => true,
            'data'    => $permissions,
        ]);
    }

    /**
     * Get permissions for a specific department
     */
    #[OA\Get(path: '/permissions/departments/{department}', operationId: 'showDepartmentPermissions', summary: 'Get permissions for a department', security: [['sanctum' => []]], tags: ['Permissions'], parameters: [new OA\Parameter(name: 'department', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Department permissions', content: new OA\JsonContent(ref: '#/components/schemas/DepartmentPermissionsResponse')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found')])]
    public function departmentPermissions(Department $department): JsonResponse
    {
        $permissions = $department->permissions()
            ->get()
            ->groupBy('resource');

        return response()->json([
            'success'     => true,
            'department'  => $department->description,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Assign permissions to a department
     */
    #[OA\Post(path: '/permissions/departments/{department}/assign', operationId: 'assignDepartmentPermissions', summary: 'Assign permissions to a department', security: [['sanctum' => []]], tags: ['Permissions'], parameters: [new OA\Parameter(name: 'department', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PermissionIdsRequest')), responses: [new OA\Response(response: 200, description: 'Permissions assigned', content: new OA\JsonContent(ref: '#/components/schemas/MessageResponse')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function assignPermissions(AssignPermissionRequest $request, Department $department): JsonResponse
    {
        $data = $request->validated();

        $department->permissions()->syncWithoutDetaching($data['permission_ids']);

        return response()->json([
            'message' => 'Permissions assigned successfully',
        ]);
    }

    /**
     * Remove permissions from a department
     */
    #[OA\Post(path: '/permissions/departments/{department}/remove', operationId: 'removeDepartmentPermissions', summary: 'Remove permissions from a department', security: [['sanctum' => []]], tags: ['Permissions'], parameters: [new OA\Parameter(name: 'department', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PermissionIdsRequest')), responses: [new OA\Response(response: 200, description: 'Permissions removed', content: new OA\JsonContent(ref: '#/components/schemas/MessageResponse')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function removePermissions(RemovePermissionRequest $request, Department $department): JsonResponse
    {
        $data = $request->validated();

        $department->permissions()->detach($data['permission_ids']);

        return response()->json([
            'message' => 'Permissions removed successfully',
        ]);
    }

    /**
     * Sync permissions for a department (replace all)
     */
    #[OA\Post(path: '/permissions/departments/{department}/sync', operationId: 'syncDepartmentPermissions', summary: 'Sync permissions for a department', security: [['sanctum' => []]], tags: ['Permissions'], parameters: [new OA\Parameter(name: 'department', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PermissionIdsRequest')), responses: [new OA\Response(response: 200, description: 'Permissions synchronized', content: new OA\JsonContent(ref: '#/components/schemas/MessageResponse')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function syncPermissions(SyncPermissionRequest $request, Department $department): JsonResponse
    {
        $data = $request->validated();

        $department->permissions()->sync($data['permission_ids']);

        return response()->json([
            'message' => 'Permissions synchronized successfully',
        ]);
    }

    /**
     * Get user's permissions
     */
    #[OA\Get(path: '/permissions/me', operationId: 'showCurrentUserPermissions', summary: 'Get permissions for the authenticated user', security: [['sanctum' => []]], tags: ['Permissions'], responses: [new OA\Response(response: 200, description: 'User permissions', content: new OA\JsonContent(ref: '#/components/schemas/UserPermissionsResponse')), new OA\Response(response: 401, description: 'Unauthenticated')])]
    public function userPermissions(Request $request): JsonResponse
    {
        $user = $request->user()->load('department.permissions');

        if (! $user->department) {
            return response()->json([
                'success'     => true,
                'message'     => 'User has no department assigned',
                'permissions' => [],
            ]);
        }

        $permissions = $user->department->permissions->groupBy('resource');

        return response()->json([
            'success'     => true,
            'user'        => $user->name,
            'department'  => $user->department->description,
            'permissions' => $permissions,
        ]);
    }
}
