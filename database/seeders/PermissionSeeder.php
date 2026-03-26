<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                    'name'     => "{$action}_{$resource}",
                    'resource' => $resource,
                    'action'   => $action,
                ]);
            }
        }

        $this->command->info('Permissions created successfully!');
        $this->command->info('Total permissions: ' . (count($resources) * count($actions)));
    }
}
