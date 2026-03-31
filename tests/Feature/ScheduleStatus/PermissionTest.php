<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('schedule-status-test');

it('should not list schedule status if not authenticated', function () {
    $response = getJson('/schedule-status');

    $response->assertUnauthorized();
});

it('should not list schedule status if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/schedule-status');

    $response->assertForbidden();
});

it('requires authentication to create a schedule status', function () {
    $response = postJson('/schedule-status', [
        'description' => 'Try to create',
        'color'       => '#FFFFFF',
        'active'      => true,
    ]);

    $response->assertUnauthorized();
});

it('requires permission to create a schedule status', function () {
    loginWithoutPermissions();

    $response = postJson('/schedule-status', [
        'description' => 'Try to create',
        'color'       => '#FFFFFF',
        'active'      => true,
    ]);

    $response->assertForbidden();
});

it('requires authentication to update a schedule status', function () {
    $response = putJson('/schedule-status/1', [
        'description' => 'Try to update',
        'color'       => '#FFFFFF',
        'active'      => true,
    ]);

    $response->assertUnauthorized();
});

it('requires permission to update a schedule status', function () {
    login();
    $scheduleStatusId = createScheduleStatus();

    loginWithoutPermissions();

    $response = putJson("/schedule-status/{$scheduleStatusId}", [
        'description' => 'Try to update',
        'color'       => '#FFFFFF',
        'active'      => true,
    ]);

    $response->assertForbidden();
});
