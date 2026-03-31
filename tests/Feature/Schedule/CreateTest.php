<?php

declare(strict_types = 1);

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
        'client_id'          => 123,
        'client_name'        => 'Client Test',
        'product_id'         => $this->productId,
        'department_id'      => $this->departmentId,
        'responsible_by'     => $this->userId,
        'scheduled_at'       => '2026-03-31',
        'initial_time'       => '08:00',
        'final_time'         => '09:00',
        'schedule_status_id' => $this->scheduleStatusId,
        'description'        => 'Schedule test description',
        'created_by'         => $this->userId,
    ];
    /** @var mixed $this */
    $this->scheduleId = createSchedule([
        'department_id'      => $this->departmentId,
        'product_id'         => $this->productId,
        'responsible_by'     => $this->userId,
        'schedule_status_id' => $this->scheduleStatusId,
        'created_by'         => $this->userId,
    ]);
});

it('client_id should be required', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'client_id' => null,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['client_id']);
    $response->assertJsonFragment([
        'client_id' => ['O campo client_id é obrigatório.'],
    ]);
});

it('client_id should be an integer', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'client_id' => 'abc',
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['client_id']);
    $response->assertJsonFragment([
        'client_id' => ['O campo client_id deve ser um número inteiro.'],
    ]);
});

it('client_name should be required', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'client_name' => '',
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['client_name']);
    $response->assertJsonFragment([
        'client_name' => ['O campo client_name é obrigatório.'],
    ]);
});

it('client_name should have a minimum length of 3 characters', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'client_name' => 'ab',
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['client_name']);
    $response->assertJsonFragment([
        'client_name' => ['O campo client_name deve ter no mínimo 3 caracteres.'],
    ]);
});

it('product_id should exist', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'product_id' => 999,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['product_id']);
    $response->assertJsonFragment([
        'product_id' => ['O campo product_id deve existir na tabela products.'],
    ]);
});

it('department_id should exist', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'department_id' => 999,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['department_id']);
    $response->assertJsonFragment([
        'department_id' => ['O campo department_id deve existir na tabela departments.'],
    ]);
});

it('responsible_by should exist', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'responsible_by' => 999,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['responsible_by']);
    $response->assertJsonFragment([
        'responsible_by' => ['O campo responsible_by deve existir na tabela users.'],
    ]);
});

it('scheduled_at should be required', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'scheduled_at' => null,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['scheduled_at']);
    $response->assertJsonFragment([
        'scheduled_at' => ['O campo scheduled_at é obrigatório.'],
    ]);
});

it('scheduled_at should have the correct format', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'scheduled_at' => '31/03/2026',
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['scheduled_at']);
});

it('schedule_status_id should exist', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'schedule_status_id' => 999,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['schedule_status_id']);
    $response->assertJsonFragment([
        'schedule_status_id' => ['O campo schedule_status_id deve existir na tabela schedule_status.'],
    ]);
});

it('created_by should exist', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'created_by' => 999,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['created_by']);
    $response->assertJsonFragment([
        'created_by' => ['O campo created_by deve existir na tabela users.'],
    ]);
});

it('description should be a string', function () {
    /** @var mixed $this */
    $response = postJson('/schedules', array_merge($this->payload, [
        'description' => 123,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo description deve ser uma string.'],
    ]);
});

it('client_id should be required on update', function () {
    /** @var mixed $this */
    $response = putJson("/schedules/{$this->scheduleId}", array_merge($this->payload, [
        'client_id' => null,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['client_id']);
    $response->assertJsonFragment([
        'client_id' => ['O campo client_id é obrigatório.'],
    ]);
});

it('client_name should be required on update', function () {
    /** @var mixed $this */
    $response = putJson("/schedules/{$this->scheduleId}", array_merge($this->payload, [
        'client_name' => '',
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['client_name']);
    $response->assertJsonFragment([
        'client_name' => ['O campo client_name é obrigatório.'],
    ]);
});

it('product_id should exist on update', function () {
    /** @var mixed $this */
    $response = putJson("/schedules/{$this->scheduleId}", array_merge($this->payload, [
        'product_id' => 999,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['product_id']);
    $response->assertJsonFragment([
        'product_id' => ['O campo product_id deve existir na tabela products.'],
    ]);
});

it('schedule_status_id should exist on update', function () {
    /** @var mixed $this */
    $response = putJson("/schedules/{$this->scheduleId}", array_merge($this->payload, [
        'schedule_status_id' => 999,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['schedule_status_id']);
    $response->assertJsonFragment([
        'schedule_status_id' => ['O campo schedule_status_id deve existir na tabela schedule_status.'],
    ]);
});

it('created_by should exist on update', function () {
    /** @var mixed $this */
    $response = putJson("/schedules/{$this->scheduleId}", array_merge($this->payload, [
        'created_by' => 999,
    ]));

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['created_by']);
    $response->assertJsonFragment([
        'created_by' => ['O campo created_by deve existir na tabela users.'],
    ]);
});

it('canceled_at should be required when canceling a schedule', function () {
    /** @var mixed $this */
    $response = patchJson("/schedules/{$this->scheduleId}/cancel", [
        'canceled_at'     => null,
        'canceled_reason' => 'Canceled because client asked for it.',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['canceled_at']);
});

it('canceled_reason should be required when canceling a schedule', function () {
    /** @var mixed $this */
    $response = patchJson("/schedules/{$this->scheduleId}/cancel", [
        'canceled_at'     => '2026-03-31 10:00:00',
        'canceled_reason' => '',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['canceled_reason']);
});

it('canceled_reason should have a minimum length of 10 characters when canceling a schedule', function () {
    /** @var mixed $this */
    $response = patchJson("/schedules/{$this->scheduleId}/cancel", [
        'canceled_at'     => '2026-03-31 10:00:00',
        'canceled_reason' => 'too short',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['canceled_reason']);
});
