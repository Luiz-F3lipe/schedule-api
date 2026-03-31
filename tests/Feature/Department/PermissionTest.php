<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('department-test');

it('should not list departments if not authenticated', function () {
    $response = getJson('/departments');

    $response->assertUnauthorized();
});

it('should not list departments if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/departments');

    $response->assertForbidden();
});

it('requires authentication to create a department', function () {
    $response = postJson('/departments', [
        'description' => 'Try to create',
        'active'      => true,
    ]);

    $response->assertUnauthorized();
});

it('requires permission to create a department', function () {
    loginWithoutPermissions();

    $response = postJson('/departments', [
        'description' => 'Try to create',
        'active'      => true,
    ]);

    $response->assertForbidden();
});

it('requires authentication to update a department', function () {
    $response = putJson('/departments/1', [
        'description' => 'Try to update',
        'active'      => true,
    ]);

    $response->assertUnauthorized();
});

it('requires permission to update a department', function () {
    login();
    $departmentId = createDepartment();

    loginWithoutPermissions();

    $response = putJson("/departments/{$departmentId}", [
        'description' => 'Try to update',
        'active'      => true,
    ]);

    $response->assertForbidden();
});
