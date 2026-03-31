<?php

declare(strict_types = 1);

use App\Models\Permission;

use function Pest\Laravel\postJson;

pest()->group('permissions-test');

beforeEach(function () {
    login();
    /** @var mixed $this */
    $this->departmentId = createDepartment();
});

it('permission_ids should be required when assigning permissions', function () {
    /** @var mixed $this */
    $response = postJson("/permissions/departments/{$this->departmentId}/assign", [
        'permission_ids' => null,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['permission_ids']);
    $response->assertJsonFragment([
        'permission_ids' => ['Por favor, selecione pelo menos uma permissão.'],
    ]);
});

it('permission_ids should be an array when assigning permissions', function () {
    /** @var mixed $this */
    $response = postJson("/permissions/departments/{$this->departmentId}/assign", [
        'permission_ids' => 'invalid',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['permission_ids']);
    $response->assertJsonFragment([
        'permission_ids' => ['Formato de permissão inválido.'],
    ]);
});

it('permission_ids should exist when assigning permissions', function () {
    /** @var mixed $this */
    $response = postJson("/permissions/departments/{$this->departmentId}/assign", [
        'permission_ids' => [999],
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['permission_ids']);
    $response->assertJsonFragment([
        'permission_ids' => ['A permissão selecionada não existe.'],
    ]);
});

it('permission_ids should be required when removing permissions', function () {
    /** @var mixed $this */
    $response = postJson("/permissions/departments/{$this->departmentId}/remove", [
        'permission_ids' => null,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['permission_ids']);
    $response->assertJsonFragment([
        'permission_ids' => ['Por favor, selecione pelo menos uma permissão.'],
    ]);
});

it('permission_ids should exist when removing permissions', function () {
    /** @var mixed $this */
    $response = postJson("/permissions/departments/{$this->departmentId}/remove", [
        'permission_ids' => 999,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['permission_ids']);
    $response->assertJsonFragment([
        'permission_ids' => ['A permissão selecionada não existe.'],
    ]);
});

it('permission_ids should be required when syncing permissions', function () {
    /** @var mixed $this */
    $response = postJson("/permissions/departments/{$this->departmentId}/sync", [
        'permission_ids' => null,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['permission_ids']);
    $response->assertJsonFragment([
        'permission_ids' => ['Por favor, selecione pelo menos uma permissão.'],
    ]);
});

it('permission_ids should exist when syncing permissions', function () {
    /** @var mixed $this */
    $response = postJson("/permissions/departments/{$this->departmentId}/sync", [
        'permission_ids' => 999,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['permission_ids']);
    $response->assertJsonFragment([
        'permission_ids' => ['A permissão selecionada não existe.'],
    ]);
});
