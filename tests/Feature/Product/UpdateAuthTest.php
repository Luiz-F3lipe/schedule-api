<?php

declare(strict_types = 1);

use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('products-test');

it('requires authentication to update a product', function () {
    $response = putJson('/products/1', [
        'description' => 'Try to update',
        'system_id'   => 1,
    ]);

    $response->assertUnauthorized();
});

it('requires permission to update a product', function () {
    login();
    $systemId = createSystem();

    $productId = postJson('/products', [
        'description' => 'New Product',
        'system_id'   => $systemId,
    ])->json('id');

    loginWithoutPermissions();

    $response = putJson('/products/1', [
        'description' => 'Try to update',
        'system_id'   => $productId,
    ]);

    $response->assertForbidden();
});
