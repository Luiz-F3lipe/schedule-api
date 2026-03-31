<?php

declare(strict_types = 1);

use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('department-test');

beforeEach(function () {
    login();
});

it('creates a department', function () {
    $response = postJson('/departments', [
        'description' => 'Created Department',
        'active'      => true,
    ]);

    $response->assertCreated();
    $response->assertJsonFragment([
        'description' => 'Created Department',
        'active'      => true,
    ]);
});

it('updates a department', function () {
    $departmentId = createDepartment('Old Department', true);

    $response = putJson("/departments/{$departmentId}", [
        'description' => 'Updated Department',
        'active'      => false,
    ]);

    $response->assertOk();
    $response->assertJsonFragment([
        'description' => 'Updated Department',
        'active'      => false,
    ]);
});
