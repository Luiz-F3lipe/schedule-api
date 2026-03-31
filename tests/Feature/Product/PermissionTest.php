<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

pest()->group('products-test');

it('should not list products if not authenticated', function () {
    $response = getJson('/products');

    $response->assertUnauthorized();
});

it('should not list products if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/products');

    $response->assertForbidden();
});

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
    $productId = createProduct();

    loginWithoutPermissions();

    $response = putJson("/products/{$productId}", [
        'description' => 'Try to update',
        'system_id'   => $systemId,
    ]);

    $response->assertForbidden();
});
