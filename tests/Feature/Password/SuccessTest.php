<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('password-test');

beforeEach(function () {
    login();
    /** @var mixed $this */
    $this->departmentId = createDepartment('Security');
    /** @var mixed $this */
    $this->productId = createProduct('Password Product');
});

it('creates a password', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => $this->departmentId,
        'product_id'    => $this->productId,
        'description'   => 'Server Password',
        'password'      => 'secret123',
        'observation'   => 'Top secret',
    ]);

    $response->assertCreated();
    $response->assertJsonFragment([
        'description' => 'Server Password',
    ]);
});

it('shows a password with its relations', function () {
    /** @var mixed $this */
    $passwordId = createPassword('Server Password', 'secret123', $this->departmentId, $this->productId, 'Top secret');

    $response = getJson("/passwords/{$passwordId}");

    $response->assertOk();
    $response->assertJsonFragment([
        'description' => 'Server Password',
        'password'    => 'secret123',
        'observation' => 'Top secret',
    ]);
});

it('updates a password', function () {
    /** @var mixed $this */
    $passwordId = createPassword('Server Password', 'secret123', $this->departmentId, $this->productId, 'Top secret');

    /** @var mixed $this */
    $response = putJson("/passwords/{$passwordId}", [
        'department_id' => $this->departmentId,
        'product_id'    => $this->productId,
        'description'   => 'Updated Password',
        'password'      => 'new-secret',
        'observation'   => 'Updated observation',
    ]);

    $response->assertOk();
    $response->assertJsonFragment([
        'description' => 'Updated Password',
        'password'    => 'new-secret',
    ]);
});
