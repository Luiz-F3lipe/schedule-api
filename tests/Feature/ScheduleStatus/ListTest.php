<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;

pest()->group('schedule-status-test');

beforeEach(function () {
    login();
});

it('should list all schedules status', function () {
    createScheduleStatus('Status A');
    createScheduleStatus('Status B');

    $response = getJson('/schedule-status');

    $response->assertOk();
    $response->assertJsonCount(2, 'data');
    $response->assertJsonFragment(['description' => 'Status A']);
    $response->assertJsonFragment(['description' => 'Status B']);
});

it('should return an empty list if there are no schedule status', function () {
    $response = getJson('/schedule-status');

    $response->assertOk();
    $response->assertJsonCount(0, 'data');
});

it('should show only specified schedule status', function () {
    $statusId = createScheduleStatus('Status A');

    $response = getJson("/schedule-status/{$statusId}");

    $response->assertOk();
    $response->assertJsonFragment(['description' => 'Status A']);
});
