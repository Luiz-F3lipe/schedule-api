<?php

declare(strict_types = 1);

use function Pest\Laravel\postJson;

pest()->group('password-test');

beforeEach(function () {
    login();
    /** @var mixed $this */
    $this->departmentId = createDepartment();
    /** @var mixed $this */
    $this->productId = createProduct();
});

it('description should be required', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => $this->departmentId,
        'product_id'    => $this->productId,
        'description'   => '',
        'password'      => 'secret123',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo description é obrigatório.'],
    ]);
});

it('description should be a string', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => $this->departmentId,
        'product_id'    => $this->productId,
        'description'   => 123,
        'password'      => 'secret123',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo description deve ser uma string.'],
    ]);
});

it('description should have a minimum length of 3 characters', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => $this->departmentId,
        'product_id'    => $this->productId,
        'description'   => 'ab',
        'password'      => 'secret123',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo description deve ter pelo menos 3 caracteres.'],
    ]);
});

it('password should be required', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => $this->departmentId,
        'product_id'    => $this->productId,
        'description'   => 'Password Test',
        'password'      => '',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['password']);
    $response->assertJsonFragment([
        'password' => ['O campo password é obrigatório.'],
    ]);
});

it('password should be a string', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => $this->departmentId,
        'product_id'    => $this->productId,
        'description'   => 'Password Test',
        'password'      => 123,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['password']);
    $response->assertJsonFragment([
        'password' => ['O campo password deve ser uma string.'],
    ]);
});

it('department_id should be an integer', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => 'abc',
        'product_id'    => $this->productId,
        'description'   => 'Password Test',
        'password'      => 'secret123',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['department_id']);
    $response->assertJsonFragment([
        'department_id' => ['O campo department_id deve ser um inteiro.'],
    ]);
});

it('department_id should exist', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => 999,
        'product_id'    => $this->productId,
        'description'   => 'Password Test',
        'password'      => 'secret123',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['department_id']);
    $response->assertJsonFragment([
        'department_id' => ['O campo department_id deve existir na tabela departments.'],
    ]);
});

it('product_id should be an integer', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => $this->departmentId,
        'product_id'    => 'abc',
        'description'   => 'Password Test',
        'password'      => 'secret123',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['product_id']);
    $response->assertJsonFragment([
        'product_id' => ['O campo product_id deve ser um inteiro.'],
    ]);
});

it('product_id should exist', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => $this->departmentId,
        'product_id'    => 999,
        'description'   => 'Password Test',
        'password'      => 'secret123',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['product_id']);
    $response->assertJsonFragment([
        'product_id' => ['O campo product_id deve existir na tabela products.'],
    ]);
});

it('observation should be a string', function () {
    /** @var mixed $this */
    $response = postJson('/passwords', [
        'department_id' => $this->departmentId,
        'product_id'    => $this->productId,
        'description'   => 'Password Test',
        'password'      => 'secret123',
        'observation'   => 123,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['observation']);
    $response->assertJsonFragment([
        'observation' => ['O campo observation deve ser uma string.'],
    ]);
});
