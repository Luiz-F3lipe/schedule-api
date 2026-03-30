<?php

declare(strict_types = 1);

use function Pest\Laravel\postJson;

pest()->group('systems-test');

beforeEach(function () {
    login();
});

it('title should be required', function () {
    $response = postJson('/systems', [
        'description' => '',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['O campo de descrição é obrigatório.'],
        ]);
});

it('title should be a string', function () {
    $response = postJson('/systems', [
        'description' => 123,
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['O campo de descrição deve ser uma string.'],
        ]);
});

it('title should have a minimum length of 3 characters', function () {
    $response = postJson('/systems', [
        'description' => 'ab',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['O campo de descrição deve ter pelo menos 3 caracteres.'],
        ]);
});

it('title should have a maximum length of 25 characters', function () {
    $response = postJson('/systems', [
        'description' => str_repeat('a', 26),
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['O campo de descrição não pode ter mais de 25 caracteres.'],
        ]);
});

it('should create a system', function () {
    $response = postJson('/systems', [
        'description' => 'Test System',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'id',
                'description',
            ],
        ]);

    expect($response->json('data.description'))->toBe('Test System');
});
