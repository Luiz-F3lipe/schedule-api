<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('schedule-test');

it('should not list schedules if not authenticated', function () {
    $response = getJson('/schedules');

    $response->assertUnauthorized();
});

it('should not list schedules if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/schedules');

    $response->assertForbidden();
});

it('requires authentication to create a schedule', function () {
    $response = postJson('/schedules', []);

    $response->assertUnauthorized();
});

it('requires permission to create a schedule', function () {
    loginWithoutPermissions();

    $response = postJson('/schedules', []);

    $response->assertForbidden();
});

it('requires authentication to update a schedule', function () {
    $response = putJson('/schedules/1', []);

    $response->assertUnauthorized();
});

it('requires permission to update a schedule', function () {
    login();
    $scheduleId = createSchedule();

    loginWithoutPermissions();

    $response = putJson("/schedules/{$scheduleId}", []);

    $response->assertForbidden();
});

it('requires authentication to cancel a schedule', function () {
    $response = patchJson('/schedules/1/cancel', []);

    $response->assertUnauthorized();
});

it('requires permission to cancel a schedule', function () {
    login();
    $scheduleId = createSchedule();

    loginWithoutPermissions();

    $response = patchJson("/schedules/{$scheduleId}/cancel", []);

    $response->assertForbidden();
});
