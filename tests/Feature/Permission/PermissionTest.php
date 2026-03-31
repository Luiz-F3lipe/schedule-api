<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

pest()->group('permissions-test');

it('should not list permissions if not authenticated', function () {
    $response = getJson('/permissions');

    $response->assertUnauthorized();
});

it('should not list permissions if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/permissions');

    $response->assertForbidden();
});

it('requires authentication to assign permissions', function () {
    $response = postJson('/permissions/departments/1/assign', [
        'permission_ids' => [1],
    ]);

    $response->assertUnauthorized();
});

it('requires permission to assign permissions', function () {
    $departmentId = createDepartment();
    loginWithoutPermissions();

    $response = postJson("/permissions/departments/{$departmentId}/assign", [
        'permission_ids' => [1],
    ]);

    $response->assertForbidden();
});

it('requires authentication to remove permissions', function () {
    $response = postJson('/permissions/departments/1/remove', [
        'permission_ids' => [1],
    ]);

    $response->assertUnauthorized();
});

it('requires permission to remove permissions', function () {
    $departmentId = createDepartment();
    loginWithoutPermissions();

    $response = postJson("/permissions/departments/{$departmentId}/remove", [
        'permission_ids' => [1],
    ]);

    $response->assertForbidden();
});

it('requires authentication to sync permissions', function () {
    $response = postJson('/permissions/departments/1/sync', [
        'permission_ids' => [1],
    ]);

    $response->assertUnauthorized();
});

it('requires permission to sync permissions', function () {
    $departmentId = createDepartment();
    loginWithoutPermissions();

    $response = postJson("/permissions/departments/{$departmentId}/sync", [
        'permission_ids' => [1],
    ]);

    $response->assertForbidden();
});
