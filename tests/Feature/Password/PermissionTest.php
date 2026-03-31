<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('password-test');

it('should not list passwords if not authenticated', function () {
    $response = getJson('/passwords');

    $response->assertUnauthorized();
});

it('should not list passwords if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/passwords');

    $response->assertForbidden();
});

it('requires authentication to create a password', function () {
    $response = postJson('/passwords', [
        'description' => 'Try to create',
        'password'    => 'secret123',
    ]);

    $response->assertUnauthorized();
});

it('requires permission to create a password', function () {
    loginWithoutPermissions();

    $response = postJson('/passwords', [
        'description' => 'Try to create',
        'password'    => 'secret123',
    ]);

    $response->assertForbidden();
});

it('requires authentication to update a password', function () {
    $response = putJson('/passwords/1', [
        'description' => 'Try to update',
        'password'    => 'secret123',
    ]);

    $response->assertUnauthorized();
});

it('requires permission to update a password', function () {
    login();
    $passwordId = createPassword();

    loginWithoutPermissions();

    $response = putJson("/passwords/{$passwordId}", [
        'description' => 'Try to update',
        'password'    => 'secret123',
    ]);

    $response->assertForbidden();
});
