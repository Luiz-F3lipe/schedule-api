<?php

declare(strict_types = 1);

use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\Request;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

pest()->group('permissions-test');

it('lists permissions grouped by resource', function () {
    login();

    $response = getJson('/permissions');

    $response->assertOk();
    $response->assertJsonPath('success', true);
    expect($response->json('data'))->toBeArray();
});

it('shows permissions for a department', function () {
    login();

    $department = Department::query()->create([
        'description' => 'Support',
        'active'      => true,
    ]);

    $permission = Permission::query()->where('resource', 'product')->where('action', 'list')->firstOrFail();

    $department->permissions()->attach($permission->id);

    $response = getJson("/permissions/departments/{$department->id}");

    $response->assertOk();
    $response->assertJsonPath('success', true);
    $response->assertJsonPath('department', 'Support');
});

it('removes permissions from a department', function () {
    login();

    $department = Department::query()->create([
        'description' => 'Remove Department',
        'active'      => true,
    ]);
    $permission = Permission::query()->create([
        'name'     => 'export_reports',
        'resource' => 'reports',
        'action'   => 'export',
    ]);

    $department->permissions()->attach($permission->id);

    $response = postJson("/permissions/departments/{$department->id}/remove", [
        'permission_ids' => $permission->id,
    ]);

    $response->assertOk();
    $response->assertJsonFragment([
        'message' => 'Permissions removed successfully',
    ]);
    expect($department->fresh()->permissions)->toHaveCount(0);
});

it('syncs permissions for a department', function () {
    login();

    $department = Department::query()->create([
        'description' => 'Sync Department',
        'active'      => true,
    ]);
    $permissionA = Permission::query()->create([
        'name'     => 'reports_export',
        'resource' => 'reports',
        'action'   => 'export',
    ]);
    $permissionB = Permission::query()->create([
        'name'     => 'reports_print',
        'resource' => 'reports',
        'action'   => 'print',
    ]);

    $department->permissions()->attach($permissionA->id);

    $response = postJson("/permissions/departments/{$department->id}/sync", [
        'permission_ids' => $permissionB->id,
    ]);

    $response->assertOk();
    $response->assertJsonFragment([
        'message' => 'Permissions synchronized successfully',
    ]);
    expect($department->fresh()->permissions()->pluck('permissions.id')->all())->toBe([$permissionB->id]);
});

it('shows current user permissions', function () {
    $user = login();

    $response = getJson('/permissions/me');

    $response->assertOk();
    $response->assertJsonPath('success', true);
    $response->assertJsonPath('user', $user->name);
});

it('returns empty permissions when authenticated user has no department relation loaded', function () {
    $user = \Mockery::mock(\App\Models\User::class)->makePartial();
    $user->name = 'No Department';
    $user->department = null;
    $user->shouldReceive('load')->with('department.permissions')->andReturnSelf();

    $request = \Mockery::mock(Request::class);
    $request->shouldReceive('user')->once()->andReturn($user);

    $controller = app(\App\Http\Controllers\Permission\PermissionController::class);
    $response = $controller->userPermissions($request);

    expect($response->getStatusCode())->toBe(200);
    expect($response->getData(true))->toMatchArray([
        'success'     => true,
        'message'     => 'User has no department assigned',
        'permissions' => [],
    ]);
});
