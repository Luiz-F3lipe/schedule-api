<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;

pest()->group('department-test');

it('should list all departments', function () {
    login();

    createDepartment('Department A');
    createDepartment('Department B');

    $response = getJson('/departments');

    $response->assertOk();
    $response->assertJsonCount(3, 'data');
    $response->assertJsonFragment(['description' => 'Department A']);
    $response->assertJsonFragment(['description' => 'Department B']);
});

it('should return an empty list if there are no departments', function () {
    login();

    $response = getJson('/departments');

    $response->assertOk();
    $response->assertJsonCount(1, 'data');
});

it('should show only specified department', function () {
    login();

    $departmentId = createDepartment('Department A');
    createDepartment('Department B');

    $response = getJson("/departments/{$departmentId}");

    $response->assertOk();
    $response->assertJsonFragment(['description' => 'Department A']);
    $response->assertJsonMissing(['description' => 'Department B']);
});
