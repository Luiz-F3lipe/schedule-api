<?php

declare(strict_types = 1);

use App\Models\Department;
use App\Models\Permission;
use App\Models\Product;
use App\Models\System;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

pest()->group('models-test');

it('department model exposes its relationships', function () {
    $department = new Department();

    expect($department->passwords())->toBeInstanceOf(HasMany::class);
    expect($department->permissions())->toBeInstanceOf(BelongsToMany::class);
    expect($department->users())->toBeInstanceOf(HasMany::class);
});

it('permission model exposes departments relationship', function () {
    $permission = new Permission();

    expect($permission->departments())->toBeInstanceOf(BelongsToMany::class);
});

it('product model exposes its relationships', function () {
    $product = new Product();

    expect($product->system())->toBeInstanceOf(BelongsTo::class);
    expect($product->passwords())->toBeInstanceOf(HasMany::class);
});

it('system model exposes products relationship', function () {
    $system = new System();

    expect($system->products())->toBeInstanceOf(HasMany::class);
});

it('user has permission returns false when department has no permission', function () {
    $department = Department::query()->create([
        'description' => 'Unit Department',
        'active'      => true,
    ]);
    $user = User::factory()->create([
        'department_id' => $department->id,
    ]);

    expect($user->hasPermission('product', 'list'))->toBeFalse();
});

it('user has permission returns false when user has no department', function () {
    $user = new User();
    $user->setRelation('department', null);

    expect($user->hasPermission('product', 'list'))->toBeFalse();
});
