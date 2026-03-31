<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;

pest()->group('schedule-test');

it('should list schedules from the authenticated user department', function () {
    $user = login();

    createSchedule([
        'department_id'  => $user->department_id,
        'responsible_by' => $user->id,
        'created_by'     => $user->id,
        'client_name'    => 'Client A',
    ]);
    createSchedule([
        'department_id'  => $user->department_id,
        'responsible_by' => $user->id,
        'created_by'     => $user->id,
        'client_name'    => 'Client B',
    ]);
    createSchedule([
        'client_name' => 'Hidden Client',
    ]);

    $response = getJson('/schedules');

    $response->assertOk();
    $response->assertJsonCount(2, 'data');
    $response->assertJsonFragment(['client_name' => 'Client A']);
    $response->assertJsonFragment(['client_name' => 'Client B']);
    $response->assertJsonMissing(['client_name' => 'Hidden Client']);
});

it('should return an empty list if there are no schedules for the authenticated user department', function () {
    login();

    $response = getJson('/schedules');

    $response->assertOk();
    $response->assertJsonCount(0, 'data');
});

it('should show only specified schedule', function () {
    login();

    $scheduleId = createSchedule(['client_name' => 'Client Show']);
    createSchedule(['client_name' => 'Client Other']);

    $response = getJson("/schedules/{$scheduleId}");

    $response->assertOk();
    $response->assertJsonFragment(['client_name' => 'Client Show']);
    $response->assertJsonMissing(['client_name' => 'Client Other']);
});
