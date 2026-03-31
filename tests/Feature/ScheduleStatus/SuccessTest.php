<?php

declare(strict_types = 1);

use function Pest\Laravel\putJson;

pest()->group('schedule-status-test');

beforeEach(function () {
    login();
});

it('updates a schedule status', function () {
    $scheduleStatusId = createScheduleStatus('Pending Status', '#123456', true);

    $response = putJson("/schedule-status/{$scheduleStatusId}", [
        'description' => 'Updated Status',
        'color'       => '#654321',
        'active'      => false,
    ]);

    $response->assertOk();
    $response->assertJsonFragment([
        'description' => 'Updated Status',
        'color'       => '#654321',
        'active'      => false,
    ]);
});
