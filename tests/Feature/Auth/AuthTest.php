<?php

declare(strict_types = 1);

use App\Models\Department;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;

pest()->group('auth-test');

it('validates login email and password fields', function () {
    $response = postJson('/auth/session', [
        'email'    => '',
        'password' => '',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['email', 'password']);
});

it('does not authenticate with invalid credentials', function () {
    $department = Department::factory()->create();
    User::factory()->create([
        'department_id' => $department->id,
        'email'         => 'auth@example.com',
        'password'      => bcrypt('1234'),
    ]);

    $response = postJson('/auth/session', [
        'email'    => 'auth@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertUnauthorized();
    $response->assertJsonFragment([
        'message' => 'Invalid credentials',
    ]);
});

it('authenticates a user and returns a token', function () {
    $department = Department::factory()->create();
    User::factory()->create([
        'department_id' => $department->id,
        'email'         => 'auth@example.com',
        'password'      => bcrypt('1234'),
    ]);

    $response = postJson('/auth/session', [
        'email'    => 'auth@example.com',
        'password' => '1234',
    ]);

    $response->assertOk();
    expect($response->json('token'))->toBeString()->not->toBeEmpty();
});

it('requires authentication to logout', function () {
    $response = postJson('/auth/logout');

    $response->assertUnauthorized();
});

it('logs out the authenticated user and revokes tokens', function () {
    $department = Department::factory()->create();
    $user = User::factory()->create([
        'department_id' => $department->id,
    ]);

    $user->createToken('token-one');
    $user->createToken('token-two');

    Sanctum::actingAs($user);

    $response = postJson('/auth/logout');

    $response->assertOk();
    $response->assertJsonFragment([
        'message' => 'Logged out successfully',
    ]);
    expect($user->fresh()->tokens()->count())->toBe(0);
});
