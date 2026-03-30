<?php

declare(strict_types = 1);
/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use App\Models\Department;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    /** @var Pest\Expectation $this */
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

use App\Models\Permission;

/**
 * Helper function to login a user with a department that has all permissions
 */
function login(): User | Authenticatable
{
    // Seed permissions if they don't exist
    if (Permission::count() === 0) {
        $resources = [
            'department',
            'product',
            'schedule_status',
            'system',
            'user',
            'schedule',
            'password',
        ];

        $actions = [
            'create',
            'edit',
            'list',
            'show',
            'delete',
        ];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::create([
                    'name'     => sprintf('%s_%s', $action, $resource),
                    'resource' => $resource,
                    'action'   => $action,
                ]);
            }
        }
    }

    // Create department with all permissions
    $department = Department::factory()->create([
        'description' => 'Test Department',
        'active'      => true,
    ]);

    // Attach all permissions to the department
    $allPermissions = Permission::all();
    $department->permissions()->attach($allPermissions->pluck('id'));

    /** @var User|Authenticatable $user */
    $user = User::factory()->create([
        'department_id' => $department->id,
    ]);

    actingAs($user);

    return $user;
}

/**
 * Helper function to login a user with a department that has all permissions
 */
function loginWithoutPermissions(): User | Authenticatable
{
    // Create department without permissions
    $department = Department::factory()->create([
        'description' => 'Test Department',
        'active'      => true,
    ]);

    /** @var User|Authenticatable $user */
    $user = User::factory()->create([
        'department_id' => $department->id,
    ]);

    actingAs($user);

    return $user;
}

/**
 * Helper function to create a system and return its ID
 *
 * @return int The ID of the created system
 */
function createSystem(string $description = 'Test System'): int
{
    $response = postJson('/systems', [
        'description' => $description,
    ]);

    $response->assertStatus(201);

    return $response->json('data.id');
}

/**
 * Helper functio to create a product and return its ID
 *
 * @return int The ID of the created product
 */
function createProduct(string $description = 'Test Product'): int
{
    $systemId = createSystem();

    $response = postJson('/products', [
        'description' => $description,
        'system_id'   => $systemId,
    ]);

    $response->assertStatus(201);

    return $response->json('data.id');
}
