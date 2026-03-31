<?php

declare(strict_types = 1);

use App\Http\Middleware\CheckPermission;
use App\Models\Department;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

pest()->group('middleware-test');

it('middleware returns unauthenticated when there is no user', function () {
    $middleware = new CheckPermission();
    $request = Request::create('/products', 'GET');

    $response = $middleware->handle(
        $request,
        fn () => response()->json(['ok' => true]),
        'product',
        'list',
    );

    expect($response->getStatusCode())->toBe(401);
});

it('middleware allows request when user has permission', function () {
    $permission = Permission::query()->create([
        'name'     => 'custom_product_list',
        'resource' => 'custom_product',
        'action'   => 'list',
    ]);

    $department = Department::query()->create([
        'description' => 'Middleware Department',
        'active'      => true,
    ]);
    $department->permissions()->attach($permission->id);

    $user = User::factory()->create([
        'department_id' => $department->id,
    ]);

    $request = Request::create('/products', 'GET');
    $request->setUserResolver(fn () => $user);

    $middleware = new CheckPermission();

    $response = $middleware->handle(
        $request,
        fn () => response()->json(['ok' => true]),
        'custom_product',
        'list',
    );

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->getStatusCode())->toBe(200);
});
