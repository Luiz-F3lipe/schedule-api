<?php

declare(strict_types = 1);

use function Pest\Laravel\getJson;

pest()->group('products-test');

it('should list all products', function () {
    login();

    createProduct('Product A');
    createProduct('Product B');

    $response = getJson('/products');

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');
    $response->assertJsonFragment(['description' => 'Product A']);
    $response->assertJsonFragment(['description' => 'Product B']);
});

it('should return an empty list if there are no products', function () {
    login();

    $response = getJson('/products');

    $response->assertStatus(200);
    $response->assertJsonCount(0, 'data');
});

it('should not list products if not authenticated', function () {
    $response = getJson('/products');

    $response->assertStatus(401);
});

it('should not list products if user does not have permission', function () {
    loginWithoutPermissions();

    $response = getJson('/products');

    $response->assertStatus(403);
});

it('should show only expecified products', function () {
    login();

    $productId = createProduct('Product A');
    createProduct('Product B');

    $response = getJson("/products/{$productId}");

    $response->assertStatus(200);
    $response->assertJsonFragment(['description' => 'Product A']);
    $response->assertJsonMissing(['description' => 'Product B']);
});
