<?php

declare(strict_types = 1);

use App\Models\Schedule;

use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('schedule-test');

beforeEach(function () {
    $user = login();

    /** @var mixed $this */
    $this->departmentId = $user->department_id;
    /** @var mixed $this */
    $this->userId = $user->id;
    /** @var mixed $this */
    $this->productId = createProduct();
    /** @var mixed $this */
    $this->scheduleStatusId = createScheduleStatus();
    /** @var mixed $this */
    $this->payload = [
        'client_id'          => 321,
        'client_name'        => 'Client Success',
        'product_id'         => $this->productId,
        'department_id'      => $this->departmentId,
        'responsible_by'     => $this->userId,
        'scheduled_at'       => '2026-04-01',
        'initial_time'       => '10:00',
        'final_time'         => '11:00',
        'schedule_status_id' => $this->scheduleStatusId,
        'description'        => 'Created from success test',
        'created_by'         => $this->userId,
    ];
});

it('creates a schedule', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', $this->payload);

    $response->assertCreated();
    $response->assertJsonFragment([
        'client_name' => 'Client Success',
    ]);

    $this->assertDatabaseHas('schedules', [
        'client_id'   => 321,
        'client_name' => 'Client Success',
    ]);
});

it('updates a schedule', function () {
    /** @var mixed $this */
    $scheduleId = createSchedule([
        'department_id'      => $this->departmentId,
        'product_id'         => $this->productId,
        'responsible_by'     => $this->userId,
        'schedule_status_id' => $this->scheduleStatusId,
        'created_by'         => $this->userId,
        'client_name'        => 'Before Update',
    ]);

    /** @var mixed $this */
    $response = putJson("/schedules/{$scheduleId}", array_merge($this->payload, [
        'client_name' => 'After Update',
    ]));

    $response->assertNoContent();
    $this->assertDatabaseHas('schedules', [
        'id'          => $scheduleId,
        'client_name' => 'After Update',
    ]);
});

it('cancels a schedule', function () {
    /** @var mixed $this */
    $scheduleId = createSchedule([
        'department_id'      => $this->departmentId,
        'product_id'         => $this->productId,
        'responsible_by'     => $this->userId,
        'schedule_status_id' => $this->scheduleStatusId,
        'created_by'         => $this->userId,
    ]);

    $response = patchJson("/schedules/{$scheduleId}/cancel", [
        'canceled_at'     => '2026-04-01 12:00:00',
        'canceled_reason' => 'Client asked to cancel this schedule.',
    ]);

    $response->assertNoContent();

    /** @var Schedule $schedule */
    $schedule = Schedule::query()->findOrFail($scheduleId);
    expect($schedule->canceled_reason)->toBe('Client asked to cancel this schedule.');
});
