<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[\Override]
    public function definition(): array
    {
        $resources = ['department', 'product', 'schedule_status', 'system', 'user', 'schedule', 'password'];
        $actions   = ['create', 'edit', 'list', 'show', 'delete'];

        $resource = fake()->randomElement($resources);
        $action   = fake()->randomElement($actions);

        return [
            'name'     => sprintf('%s_%s', $action, $resource),
            'resource' => $resource,
            'action'   => $action,
        ];
    }
}
