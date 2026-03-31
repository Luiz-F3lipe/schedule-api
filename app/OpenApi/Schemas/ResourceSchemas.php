<?php

declare(strict_types = 1);

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'DepartmentResource',
    required: ['id', 'description', 'active'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'description', type: 'string', example: 'Financeiro'),
        new OA\Property(property: 'active', type: 'boolean', example: true),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'DepartmentCollection',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/DepartmentResource')
        ),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'SystemResource',
    required: ['id', 'description'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'description', type: 'string', example: 'ERP'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'SystemCollection',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/SystemResource')
        ),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ProductResource',
    required: ['id', 'description', 'system'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'description', type: 'string', example: 'Produto A'),
        new OA\Property(property: 'system', ref: '#/components/schemas/SystemResource'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ProductCollection',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/ProductResource')
        ),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ScheduleStatusResource',
    required: ['id', 'description', 'color', 'active'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'description', type: 'string', example: 'Agendado'),
        new OA\Property(property: 'color', type: 'string', example: '#22C55E'),
        new OA\Property(property: 'active', type: 'boolean', example: true),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ScheduleStatusCollection',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/ScheduleStatusResource')
        ),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PasswordResource',
    required: ['id', 'description', 'department', 'product'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'description', type: 'string', example: 'Senha VPN'),
        new OA\Property(property: 'department', ref: '#/components/schemas/DepartmentResource', nullable: true),
        new OA\Property(property: 'product', ref: '#/components/schemas/ProductResource', nullable: true),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PasswordDetailResource',
    required: ['id', 'description', 'password', 'observation', 'department', 'product'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'description', type: 'string', example: 'Senha VPN'),
        new OA\Property(property: 'password', type: 'string', example: 'secret123'),
        new OA\Property(property: 'observation', type: 'string', nullable: true, example: 'Trocar mensalmente'),
        new OA\Property(property: 'department', ref: '#/components/schemas/DepartmentResource', nullable: true),
        new OA\Property(property: 'product', ref: '#/components/schemas/ProductResource', nullable: true),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PasswordCollection',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/PasswordResource')
        ),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'UserResource',
    required: ['id', 'department', 'name', 'email'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'department', ref: '#/components/schemas/DepartmentResource'),
        new OA\Property(property: 'name', type: 'string', example: 'Maria Silva'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'maria@example.com'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'UserCollection',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/UserResource')
        ),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ScheduleResource',
    required: ['id', 'client_name', 'responsible_by', 'scheduled_at', 'initial_time', 'final_time', 'schedule_status', 'canceled_at'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'client_name', type: 'string', example: 'Cliente XPTO'),
        new OA\Property(property: 'responsible_by', type: 'string', example: 'Maria Silva'),
        new OA\Property(property: 'scheduled_at', type: 'string', format: 'date', example: '2026-03-31'),
        new OA\Property(property: 'initial_time', type: 'string', example: '09:00'),
        new OA\Property(property: 'final_time', type: 'string', nullable: true, example: '10:00'),
        new OA\Property(property: 'schedule_status', type: 'string', example: 'Agendado'),
        new OA\Property(property: 'canceled_at', type: 'string', format: 'date-time', nullable: true),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ScheduleDetailResource',
    required: ['id', 'client_id', 'client_name', 'responsible_by', 'scheduled_at', 'initial_time', 'final_time', 'description', 'created_by', 'canceled_at', 'canceled_reason', 'product', 'department', 'schedule_status'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'client_id', type: 'integer', example: 1001),
        new OA\Property(property: 'client_name', type: 'string', example: 'Cliente XPTO'),
        new OA\Property(property: 'responsible_by', type: 'string', nullable: true, example: 'Maria Silva'),
        new OA\Property(property: 'scheduled_at', type: 'string', format: 'date', example: '2026-03-31'),
        new OA\Property(property: 'initial_time', type: 'string', example: '09:00'),
        new OA\Property(property: 'final_time', type: 'string', nullable: true, example: '10:00'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Reunião de alinhamento'),
        new OA\Property(property: 'created_by', type: 'string', nullable: true, example: 'João Silva'),
        new OA\Property(property: 'canceled_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'canceled_reason', type: 'string', nullable: true),
        new OA\Property(property: 'product', ref: '#/components/schemas/ProductResource'),
        new OA\Property(property: 'department', ref: '#/components/schemas/DepartmentResource'),
        new OA\Property(property: 'schedule_status', ref: '#/components/schemas/ScheduleStatusResource'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ScheduleCollection',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/ScheduleResource')
        ),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PermissionResource',
    required: ['id', 'name', 'resource', 'action'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'list_department'),
        new OA\Property(property: 'resource', type: 'string', example: 'department'),
        new OA\Property(property: 'action', type: 'string', example: 'list'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PermissionsGroupedResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', type: 'object', additionalProperties: new OA\AdditionalProperties(type: 'array', items: new OA\Items(ref: '#/components/schemas/PermissionResource'))),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'DepartmentPermissionsResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'department', type: 'string', example: 'Financeiro'),
        new OA\Property(property: 'permissions', type: 'object', additionalProperties: new OA\AdditionalProperties(type: 'array', items: new OA\Items(ref: '#/components/schemas/PermissionResource'))),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'UserPermissionsResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'message', type: 'string', nullable: true, example: 'User has no department assigned'),
        new OA\Property(property: 'user', type: 'string', nullable: true, example: 'Maria Silva'),
        new OA\Property(property: 'department', type: 'string', nullable: true, example: 'Financeiro'),
        new OA\Property(property: 'permissions', type: 'object', additionalProperties: new OA\AdditionalProperties(type: 'array', items: new OA\Items(ref: '#/components/schemas/PermissionResource'))),
    ],
    type: 'object'
)]
final class ResourceSchemas
{
}
