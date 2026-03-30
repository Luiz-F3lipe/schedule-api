<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;

pest()->group('systems-test');

it('should list all systems', function () {
    login();

    createSystem('System A');
    createSystem('System B');

    $response = getJson('/systems');

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');
    $response->assertJsonFragment(['description' => 'System A']);
    $response->assertJsonFragment(['description' => 'System B']);
});

it('should return an empty list if there are no systems', function () {
    login();

    $response = getJson('/systems');

    $response->assertStatus(200);
    $response->assertJsonCount(0, 'data');
});

it('should not list systems if not authenticated', function () {
    $response = getJson('/systems');

    $response->assertStatus(401);
});

it('should not list systems if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/systems');

    $response->assertStatus(403);
});

it('should show only expecified system', function () {
    login();

    $systemId = createSystem('System A');
    createSystem('System B');

    $response = getJson("/systems/{$systemId}");

    $response->assertStatus(200);
    $response->assertJsonFragment(['description' => 'System A']);
    $response->assertJsonMissing(['description' => 'System B']);
});
