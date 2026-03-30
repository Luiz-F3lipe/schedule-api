<?php

declare(strict_types = 1);

use function Pest\Laravel\putJson;

pest()->group('systems-test');

it('requires authentication to update a system', function () {
    $response = putJson('/systems/999', [
        'description' => 'Try to Update',
    ]);

    // Deve retornar 401 Unauthorized pois não está autenticado
    $response->assertStatus(401);
});

it('requires permission to update a system', function () {
    // Primeiro cria um sistema COM permissões
    login();
    $systemId = createSystem();

    // Agora faz login com um usuário SEM permissões
    loginWithoutPermissions();

    $response = putJson("/systems/{$systemId}", [
        'description' => 'Try to Update',
    ]);

    // Deve retornar 403 Forbidden pois o usuário não tem permissão de edit_system
    $response->assertStatus(403);
});
