<?php

declare(strict_types = 1);

use function Pest\Laravel\putJson;

pest()->group('department-test');

beforeEach(function () {
    login();
    /** @var mixed $this */
    $this->departmentId = createDepartment();
});

it('description should be required on update', function () {
    /** @var mixed $this */
    $response = putJson("/departments/{$this->departmentId}", [
        'description' => '',
        'active'      => true,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo de descrição é obrigatório.'],
    ]);
});

it('description should be a string on update', function () {
    /** @var mixed $this */
    $response = putJson("/departments/{$this->departmentId}", [
        'description' => 123,
        'active'      => true,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo de descrição deve ser uma string.'],
    ]);
});

it('description should have a minimum length of 3 characters on update', function () {
    /** @var mixed $this */
    $response = putJson("/departments/{$this->departmentId}", [
        'description' => 'ab',
        'active'      => true,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo de descrição deve ter pelo menos 3 caracteres.'],
    ]);
});

it('description should have a maximum length of 50 characters on update', function () {
    /** @var mixed $this */
    $response = putJson("/departments/{$this->departmentId}", [
        'description' => str_repeat('a', 51),
        'active'      => true,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo de descrição não pode ter mais de 50 caracteres.'],
    ]);
});

it('active should be required on update', function () {
    /** @var mixed $this */
    $response = putJson("/departments/{$this->departmentId}", [
        'description' => 'Department Test',
        'active'      => null,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['active']);
    $response->assertJsonFragment([
        'active' => ['O campo ativo é obrigatório.'],
    ]);
});

it('active should be a boolean on update', function () {
    /** @var mixed $this */
    $response = putJson("/departments/{$this->departmentId}", [
        'description' => 'Department Test',
        'active'      => 'invalid',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['active']);
    $response->assertJsonFragment([
        'active' => ['O campo ativo deve ser verdadeiro ou falso.'],
    ]);
});
