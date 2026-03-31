<?php

declare(strict_types = 1);

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

pest()->group('documentation-test');

it('serves the swagger ui route', function () {
    $response = get('/docs');

    $response->assertOk();
    $response->assertSee('swagger-ui');
    $response->assertSee('/docs/openapi', false);
});

it('serves the openapi document route', function () {
    $response = getJson('/docs/openapi');

    $response->assertOk();
    $response->assertJsonPath('info.title', 'Schedule API');
    $response->assertJsonPath('paths./auth/session.post.tags.0', 'Auth');
});
