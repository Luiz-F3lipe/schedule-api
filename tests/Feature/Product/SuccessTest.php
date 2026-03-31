<?php

declare(strict_types = 1);

use function Pest\Laravel\putJson;

pest()->group('products-test');

beforeEach(function () {
    login();
    /** @var mixed $this */
    $this->systemId = createSystem('Updated System');
});

it('updates a product', function () {
    /** @var mixed $this */
    $productId = createProduct('Old Product');

    /** @var mixed $this */
    $response = putJson("/products/{$productId}", [
        'description' => 'Updated Product',
        'system_id'   => $this->systemId,
    ]);

    $response->assertOk();
    $response->assertJsonFragment([
        'description' => 'Updated Product',
    ]);
});
