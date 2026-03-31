<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('systems-test');

it('should not list systems if not authenticated', function () {
    $response = getJson('/systems');

    $response->assertUnauthorized();
});

it('should not list systems if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/systems');

    $response->assertForbidden();
});

it('requires authentication to create a system', function () {
    $response = postJson('/systems', [
        'description' => 'Try to create',
    ]);

    $response->assertUnauthorized();
});

it('requires permission to create a system', function () {
    loginWithoutPermissions();

    $response = postJson('/systems', [
        'description' => 'Try to Create',
    ]);

    $response->assertForbidden();
});

it('requires authentication to update a system', function () {
    $response = putJson('/systems/999', [
        'description' => 'Try to Update',
    ]);

    $response->assertUnauthorized();
});

it('requires permission to update a system', function () {
    login();
    $systemId = createSystem();

    loginWithoutPermissions();

    $response = putJson("/systems/{$systemId}", [
        'description' => 'Try to Update',
    ]);

    $response->assertForbidden();
});
