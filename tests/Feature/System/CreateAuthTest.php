<?php

declare(strict_types = 1);

use function Pest\Laravel\postJson;

pest()->group('systems-test');

it('requires authentication to update a system', function () {
    $response = postJson('/systems', [
        'description' => 'Try to create',
    ]);

    // Deve retornar 401 Unauthorized pois não está autenticado
    $response->assertStatus(401);
});

it('requires permission to update a system', function () {
    loginWithoutPermissions();

    $response = postJson("/systems", [
        'description' => 'Try to Create',
    ]);

    // Deve retornar 403 Forbidden pois o usuário não tem permissão de edit_system
    $response->assertStatus(403);
});
