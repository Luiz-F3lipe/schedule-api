<?php

declare(strict_types = 1);

use function Pest\Laravel\postJson;

pest()->group('products-test');

it('requires authentication to create a product', function () {
    $response = postJson('/products', [
        'description' => 'Try to create',
        'system_id'   => 1,
    ]);

    $response->assertUnauthorized();
});

it('requires permission to create a product', function () {
    loginWithoutPermissions();

    $response = postJson('/products', [
        'description' => 'Try to create',
        'system_id'   => 1,
    ]);

    $response->assertForbidden();
});
