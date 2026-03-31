<?php

declare(strict_types = 1);

use App\Models\User;

use function Pest\Laravel\postJson;

pest()->group('user-test');

beforeEach(function () {
    login();
    /** @var mixed $this */
    $this->departmentId = createDepartment();
    User::factory()->create(['email' => 'existing@example.com']);
});

it('name should be required', function () {
    /** @var mixed $this */
    $response = postJson('/user', [
        'name'          => '',
        'email'         => 'user@example.com',
        'password'      => '1234',
        'department_id' => $this->departmentId,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['name']);
    $response->assertJsonFragment([
        'name' => ['O campo nome é obrigatório.'],
    ]);
});

it('name should be a string', function () {
    /** @var mixed $this */
    $response = postJson('/user', [
        'name'          => 1234,
        'email'         => 'user@example.com',
        'password'      => '1234',
        'department_id' => $this->departmentId,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['name']);
    $response->assertJsonFragment([
        'name' => ['O nome deve ser uma string.'],
    ]);
});

it('name should have a minimum length of 4 characters', function () {
    /** @var mixed $this */
    $response = postJson('/user', [
        'name'          => 'abc',
        'email'         => 'user@example.com',
        'password'      => '1234',
        'department_id' => $this->departmentId,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['name']);
    $response->assertJsonFragment([
        'name' => ['O nome deve ter pelo menos 4 caracteres.'],
    ]);
});

it('email should be required', function () {
    /** @var mixed $this */
    $response = postJson('/user', [
        'name'          => 'Test User',
        'email'         => '',
        'password'      => '1234',
        'department_id' => $this->departmentId,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['email']);
    $response->assertJsonFragment([
        'email' => ['O campo e-mail é obrigatório.'],
    ]);
});

it('email should be valid', function () {
    /** @var mixed $this */
    $response = postJson('/user', [
        'name'          => 'Test User',
        'email'         => 'invalid-email',
        'password'      => '1234',
        'department_id' => $this->departmentId,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['email']);
    $response->assertJsonFragment([
        'email' => ['O e-mail deve ser um endereço de e-mail válido.'],
    ]);
});

it('email should be unique', function () {
    /** @var mixed $this */
    $response = postJson('/user', [
        'name'          => 'Test User',
        'email'         => 'existing@example.com',
        'password'      => '1234',
        'department_id' => $this->departmentId,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['email']);
    $response->assertJsonFragment([
        'email' => ['Este e-mail já está em uso.'],
    ]);
});

it('password should be required', function () {
    /** @var mixed $this */
    $response = postJson('/user', [
        'name'          => 'Test User',
        'email'         => 'user@example.com',
        'password'      => '',
        'department_id' => $this->departmentId,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['password']);
    $response->assertJsonFragment([
        'password' => ['O campo senha é obrigatório.'],
    ]);
});

it('department_id should be required', function () {
    $response = postJson('/user', [
        'name'          => 'Test User',
        'email'         => 'user@example.com',
        'password'      => '1234',
        'department_id' => null,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['department_id']);
    $response->assertJsonFragment([
        'department_id' => ['O campo departamento é obrigatório.'],
    ]);
});

it('department_id should be an integer', function () {
    $response = postJson('/user', [
        'name'          => 'Test User',
        'email'         => 'user@example.com',
        'password'      => '1234',
        'department_id' => 'abc',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['department_id']);
    $response->assertJsonFragment([
        'department_id' => ['O departamento deve ser um número inteiro.'],
    ]);
});

it('department_id should exist', function () {
    $response = postJson('/user', [
        'name'          => 'Test User',
        'email'         => 'user@example.com',
        'password'      => '1234',
        'department_id' => 999,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['department_id']);
    $response->assertJsonFragment([
        'department_id' => ['O departamento selecionado é inválido.'],
    ]);
});
