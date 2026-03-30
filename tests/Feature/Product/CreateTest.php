<?php

declare(strict_types = 1);

use function Pest\Laravel\postJson;

pest()->group('products-test');

beforeEach(function () {
    login();
});

it('description should be required', function () {
    $response = postJson('/products', [
        'description' => '',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo de descrição é obrigatório.'],
    ]);
});

it('description should be a string', function () {
    $response = postJson('/products', [
        'description' => 123,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo de descrição deve ser uma string.'],
    ]);
});

it('description should have a minimum length of 3 characters', function () {
    $response = postJson('/products', [
        'description' => 'ab',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo de descrição deve ter pelo menos 3 caracteres.'],
    ]);
});

it('description should have a maximum length of 50 characters', function () {
    $response = postJson('/products', [
        'description' => str_repeat('a', 51),
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['description']);
    $response->assertJsonFragment([
        'description' => ['O campo de descrição não pode ter mais de 50 caracteres.'],
    ]);
});

it('system_id should be required', function () {
    $response = postJson('/products', [
        'system_id' => '',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['system_id']);
    $response->assertJsonFragment([
        'system_id' => ['O campo system_id é obrigatório.'],
    ]);
});

it('system_id should be integer', function () {
    $response = postJson('/products', [
        'system_id' => 'abc',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['system_id']);
    $response->assertJsonFragment([
        'system_id' => ['O campo system_id deve ser um número inteiro.'],
    ]);
});

it('system_id should be a valid ID', function () {
    $response = postJson('/products', [
        'system_id' => 999,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['system_id']);
    $response->assertJsonFragment([
        'system_id' => ['O system_id fornecido não existe.'],
    ]);
});
