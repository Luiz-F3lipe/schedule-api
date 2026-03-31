<?php

declare(strict_types = 1);

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'DepartmentRequest',
    required: ['description', 'active'],
    properties: [
        new OA\Property(property: 'description', type: 'string', maxLength: 50, minLength: 3, example: 'Financeiro'),
        new OA\Property(property: 'active', type: 'boolean', example: true),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'SystemRequest',
    required: ['description'],
    properties: [
        new OA\Property(property: 'description', type: 'string', maxLength: 25, minLength: 3, example: 'ERP'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ProductRequest',
    required: ['system_id', 'description'],
    properties: [
        new OA\Property(property: 'system_id', type: 'integer', example: 1),
        new OA\Property(property: 'description', type: 'string', maxLength: 50, minLength: 3, example: 'Produto A'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ScheduleStatusRequest',
    required: ['description', 'color', 'active'],
    properties: [
        new OA\Property(property: 'description', type: 'string', maxLength: 30, minLength: 3, example: 'Agendado'),
        new OA\Property(property: 'color', type: 'string', minLength: 7, maxLength: 7, example: '#22C55E'),
        new OA\Property(property: 'active', type: 'boolean', example: true),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ScheduleRequest',
    required: ['client_id', 'client_name', 'product_id', 'department_id', 'responsible_by', 'scheduled_at', 'initial_time', 'schedule_status_id', 'created_by'],
    properties: [
        new OA\Property(property: 'client_id', type: 'integer', example: 1001),
        new OA\Property(property: 'client_name', type: 'string', maxLength: 255, minLength: 3, example: 'Cliente XPTO'),
        new OA\Property(property: 'product_id', type: 'integer', example: 1),
        new OA\Property(property: 'department_id', type: 'integer', example: 1),
        new OA\Property(property: 'responsible_by', type: 'integer', example: 1),
        new OA\Property(property: 'scheduled_at', type: 'string', format: 'date', example: '2026-03-31'),
        new OA\Property(property: 'initial_time', type: 'string', example: '09:00'),
        new OA\Property(property: 'final_time', type: 'string', nullable: true, example: '10:00'),
        new OA\Property(property: 'schedule_status_id', type: 'integer', example: 1),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Reunião de alinhamento'),
        new OA\Property(property: 'created_by', type: 'integer', example: 1),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'CancelScheduleRequest',
    required: ['canceled_at', 'canceled_reason'],
    properties: [
        new OA\Property(property: 'canceled_at', type: 'string', format: 'date-time', example: '2026-03-31T15:00:00Z'),
        new OA\Property(property: 'canceled_reason', type: 'string', maxLength: 255, minLength: 10, example: 'Cliente solicitou cancelamento'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PasswordRequest',
    required: ['description', 'password'],
    properties: [
        new OA\Property(property: 'department_id', type: 'integer', nullable: true, example: 1),
        new OA\Property(property: 'product_id', type: 'integer', nullable: true, example: 1),
        new OA\Property(property: 'description', type: 'string', maxLength: 255, minLength: 3, example: 'Senha VPN'),
        new OA\Property(property: 'password', type: 'string', maxLength: 255, minLength: 3, example: 'secret123'),
        new OA\Property(property: 'observation', type: 'string', nullable: true, maxLength: 255, example: 'Trocar mensalmente'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'UserRequest',
    required: ['name', 'email', 'password', 'department_id'],
    properties: [
        new OA\Property(property: 'name', type: 'string', maxLength: 255, minLength: 4, example: 'Maria Silva'),
        new OA\Property(property: 'email', type: 'string', format: 'email', maxLength: 255, example: 'maria@example.com'),
        new OA\Property(property: 'password', type: 'string', format: 'password', minLength: 4, example: 'secret'),
        new OA\Property(property: 'department_id', type: 'integer', example: 1),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PermissionIdsRequest',
    required: ['permission_ids'],
    properties: [
        new OA\Property(
            property: 'permission_ids',
            type: 'array',
            items: new OA\Items(type: 'integer'),
            example: [1, 2, 3]
        ),
    ],
    type: 'object'
)]
final class RequestSchemas
{
}
