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

class PermissionController extends Controller
{
    /**
     * List all permissions
     */
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
    public function assignPermissions(AssignPermissionRequest $request, Department $department)
    {
        return $request->validated();
    }

    /**
     * Remove permissions from a department
     */
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
