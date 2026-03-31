<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

pest()->group('user-test');

it('should not list users if not authenticated', function () {
    $response = getJson('/user');

    $response->assertUnauthorized();
});

it('should not list users if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/user');

    $response->assertForbidden();
});

it('requires authentication to create a user', function () {
    $response = postJson('/user', [
        'name'          => 'Try to create',
        'email'         => 'user@example.com',
        'password'      => '1234',
        'department_id' => 1,
    ]);

    $response->assertUnauthorized();
});

it('requires permission to create a user', function () {
    loginWithoutPermissions();

    $response = postJson('/user', [
        'name'          => 'Try to create',
        'email'         => 'user@example.com',
        'password'      => '1234',
        'department_id' => 1,
    ]);

    $response->assertForbidden();
});
