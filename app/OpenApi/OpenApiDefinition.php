<?php

declare(strict_types = 1);

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Schedule API',
    description: 'OpenAPI documentation for the schedule API.'
)]
#[OA\Server(
    url: '/',
    description: 'Current application server'
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'Bearer token',
    description: 'Authenticate with a Laravel Sanctum bearer token.'
)]
#[OA\Tag(name: 'Auth', description: 'Authentication endpoints')]
#[OA\Tag(name: 'Departments', description: 'Department management endpoints')]
#[OA\Tag(name: 'Systems', description: 'System management endpoints')]
#[OA\Tag(name: 'Products', description: 'Product management endpoints')]
#[OA\Tag(name: 'Schedule Status', description: 'Schedule status management endpoints')]
#[OA\Tag(name: 'Schedules', description: 'Schedule management endpoints')]
#[OA\Tag(name: 'Passwords', description: 'Password management endpoints')]
#[OA\Tag(name: 'Users', description: 'User management endpoints')]
#[OA\Tag(name: 'Permissions', description: 'Permission management endpoints')]
#[OA\Tag(name: 'Documentation', description: 'OpenAPI and Swagger UI routes')]
final class OpenApiDefinition
{
}
