<?php

declare(strict_types = 1);

use function Pest\Laravel\postJson;

pest()->group('schedule-status-test');

beforeEach(function () {
    login();
});

it('description should be required', function () {
    $response = postJson('/schedule-status', [
        'description' => '',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['A descrição é obrigatória.'],
        ]);
});

it('description should be a string', function () {
    $response = postJson('/schedule-status', [
        'description' => 123,
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['A descrição deve ser uma string.'],
        ]);
});

it('description should have a minimum length of 3 characters ', function () {
    $response = postJson('/schedule-status', [
        'description' => 'ab',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['A descrição deve ter no mínimo 3 caracteres.'],
        ]);
});

it('description should have a maximum length of 30 characters', function () {
    $response = postJson('/schedule-status', [
        'description' => str_repeat('a', 31),
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['A descrição deve ter no máximo 30 caracteres.'],
        ]);
});

it('color should be required', function () {
    $response = postJson('/schedule-status', [
        'color' => '',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['color'])
        ->assertJsonFragment([
            'color' => ['A cor é obrigatória.'],
        ]);
});

it('color should be a string', function () {
    $response = postJson('/schedule-status', [
        'color' => 123,
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['color'])
        ->assertJsonFragment([
            'color' => [
                'A cor deve ser uma string.',
                'A cor deve ter exatamente 7 caracteres.',
            ],
        ]);
});

it('color should have size 7', function () {
    $response = postJson('/schedule-status', [
        'color' => '#1234567',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['color'])
        ->assertJsonFragment([
            'color' => ['A cor deve ter exatamente 7 caracteres.'],
        ]);
});

it('active should be required', function () {
    $response = postJson('/schedule-status', [
        'active' => null,
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['active'])
        ->assertJsonFragment([
            'active' => ['O status ativo é obrigatório.'],
        ]);
});

it('active should be a boolean', function () {
    $response = postJson('/schedule-status', [
        'active' => 'not-a-boolean',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['active'])
        ->assertJsonFragment([
            'active' => ['O status ativo deve ser verdadeiro ou falso.'],
        ]);
});

it('should create a schedule status', function () {
    $response = postJson('/schedule-status', [
        'description' => 'Test Status',
        'color'       => '#123456',
        'active'      => true,
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'description',
                'color',
                'active',
            ],
        ])
        ->assertJsonFragment([
            'description' => 'Test Status',
            'color'       => '#123456',
            'active'      => true,
        ]);
});
