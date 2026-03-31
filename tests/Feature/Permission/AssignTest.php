<?php

declare(strict_types = 1);

use App\Models\Department;
use App\Models\Permission;

use function Pest\Laravel\postJson;

pest()->group('permissions-test');

beforeEach(function () {
    login();
});

it('assigns permissions to a department without detaching existing ones', function () {
    $department = Department::factory()->create();

    $existingPermission = Permission::firstOrCreate([
        'name' => 'list_department',
        'resource' => 'department',
        'action' => 'list',
    ]);

    $newPermission = Permission::firstOrCreate([
        'name' => 'edit_department',
        'resource' => 'department',
        'action' => 'edit',
    ]);

    $department->permissions()->attach($existingPermission->id);

    $response = postJson("/permissions/departments/{$department->id}/assign", [
        'permission_ids' => [$existingPermission->id, $newPermission->id],
    ]);

    $response->assertOk()
        ->assertJson([
            'message' => 'Permissions assigned successfully',
        ]);

    expect($department->fresh()->permissions()->pluck('permissions.id')->sort()->values()->all())
        ->toBe(collect([$existingPermission->id, $newPermission->id])->sort()->values()->all());
});
