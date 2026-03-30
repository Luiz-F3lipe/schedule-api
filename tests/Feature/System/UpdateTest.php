<?php

declare(strict_types = 1);

use function Pest\Laravel\putJson;

pest()->group('systems-test');

beforeEach(function () {
    login();
});

it('title should be required', function () {
    $systemId = createSystem();

    $response = putJson("/systems/{$systemId}", [
        'description' => '',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['O campo de descrição é obrigatório.'],
        ]);
});

it('title should be a string', function () {
    $systemId = createSystem();

    $response = putJson("/systems/{$systemId}", [
        'description' => 123,
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['O campo de descrição deve ser uma string.'],
        ]);
});

it('title should have a minimum length of 3 characters', function () {
    $systemId = createSystem();

    $response = putJson("/systems/{$systemId}", [
        'description' => 'ab',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['O campo de descrição deve ter pelo menos 3 caracteres.'],
        ]);
});

it('title should have a maximum length of 25 characters', function () {
    $systemId = createSystem();

    $response = putJson("/systems/{$systemId}", [
        'description' => str_repeat('a', 26),
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['description'])
        ->assertJsonFragment([
            'description' => ['O campo de descrição não pode ter mais de 25 caracteres.'],
        ]);
});

it('should update a system', function () {
    $systemId = createSystem();

    $updateResponse = putJson("/systems/{$systemId}", [
        'description' => 'Updated Test System',
    ]);

    $updateResponse->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'description',
            ],
        ]);

    expect($updateResponse->json('data.description'))->toBe('Updated Test System');
});
