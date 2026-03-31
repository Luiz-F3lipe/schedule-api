<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;

pest()->group('password-test');

it('should list all passwords', function () {
    login();

    createPassword('Password A', 'secret-a');
    createPassword('Password B', 'secret-b');

    $response = getJson('/passwords');

    $response->assertOk();
    $response->assertJsonCount(2, 'data');
    $response->assertJsonFragment(['description' => 'Password A']);
    $response->assertJsonFragment(['description' => 'Password B']);
});

it('should return an empty list if there are no passwords', function () {
    login();

    $response = getJson('/passwords');

    $response->assertOk();
    $response->assertJsonCount(0, 'data');
});

it('should show only specified password', function () {
    login();

    $passwordId = createPassword('Password A', 'secret-a');
    createPassword('Password B', 'secret-b');

    $response = getJson("/passwords/{$passwordId}");

    $response->assertOk();
    $response->assertJsonFragment(['description' => 'Password A']);
    $response->assertJsonMissing(['description' => 'Password B']);
});
