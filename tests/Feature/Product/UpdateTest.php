<?php

declare(strict_types = 1);

use function Pest\Laravel\putJson;

pest()->group('products-test');

beforeEach(function () {
    login();
    /** @var mixed $this */
    $this->systemId  = createSystem();
    $this->productId = createProduct();
});

it('description should be required', function () {
    /** @var mixed $this */
    $response = putJson("/products/{$this->productId}", [
        'description' => '',
        'system_id'   => $this->systemId,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('description');
    $response->assertJsonFragment([
        'description' => ['O campo de descrição é obrigatório.'],
    ]);
});

it('description should be a string', function () {
    /** @var mixed $this */
    $response = putJson("/products/{$this->productId}", [
        'description' => 123,
        'system_id'   => $this->systemId,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('description');
    $response->assertJsonFragment([
        'description' => ['O campo de descrição deve ser uma string.'],
    ]);
});

it('description should not exceed 50 characters', function () {
    /** @var mixed $this */
    $response = putJson("/products/{$this->productId}", [
        'description' => str_repeat('a', 51),
        'system_id'   => $this->systemId,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('description');
    $response->assertJsonFragment([
        'description' => ['O campo de descrição não pode ter mais de 50 caracteres.'],
    ]);
});

it('description should be at least 3 characters', function () {
    /** @var mixed $this */
    $response = putJson("/products/{$this->productId}", [
        'description' => 'ab',
        'system_id'   => $this->systemId,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('description');
    $response->assertJsonFragment([
        'description' => ['O campo de descrição deve ter pelo menos 3 caracteres.'],
    ]);
});

it('system_id should be required', function () {
    /** @var mixed $this */
    $response = putJson("/products/{$this->productId}", [
        'description' => 'Valid description',
        'system_id'   => null,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('system_id');
    $response->assertJsonFragment([
        'system_id' => ['O campo system_id é obrigatório.'],
    ]);
});

it('system_id should be a integer', function () {
    /** @var mixed $this */
    $response = putJson("/products/{$this->productId}", [
        'description' => 'Valid description',
        'system_id'   => 'not-an-integer',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('system_id');
    $response->assertJsonFragment([
        'system_id' => ['O campo system_id deve ser um número inteiro.'],
    ]);
});

it('system_id should be a valid ID', function () {
    /** @var mixed $this */
    $response = putJson("/products/{$this->productId}", [
        'description' => 'Valid description',
        'system_id'   => 99999,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('system_id');
    $response->assertJsonFragment([
        'system_id' => ['O system_id fornecido não existe.'],
    ]);
});
