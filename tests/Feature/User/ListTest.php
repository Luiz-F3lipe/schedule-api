<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;

pest()->group('user-test');

it('should list all users', function () {
    login();

    $departmentId = createDepartment();
    createUser('User One', 'user-one@example.com', $departmentId);
    createUser('User Two', 'user-two@example.com', $departmentId);

    $response = getJson('/user');

    $response->assertOk();
    $response->assertJsonCount(3, 'data');
    $response->assertJsonFragment(['name' => 'User One']);
    $response->assertJsonFragment(['name' => 'User Two']);
});

it('should return an empty list if there are no extra users', function () {
    login();

    $response = getJson('/user');

    $response->assertOk();
    $response->assertJsonCount(1, 'data');
});

it('should show only specified user', function () {
    login();

    $departmentId = createDepartment();
    $userId = createUser('User One', 'user-show@example.com', $departmentId);
    createUser('User Two', 'user-other@example.com', $departmentId);

    $response = getJson("/user/{$userId}");

    $response->assertOk();
    $response->assertJsonFragment(['name' => 'User One']);
    $response->assertJsonMissing(['name' => 'User Two']);
});
