<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria o departamento de teste/admin com todas as permissões
        $department = Department::create([
            'description' => 'Administração',
            'active'      => true,
        ]);

        // Busca todas as permissões
        $allPermissions = Permission::all();

        // Associa todas as permissões ao departamento
        $department->permissions()->attach($allPermissions->pluck('id'));

        $this->command->info('Department created successfully!');
        $this->command->info('Department: ' . $department->description);
        $this->command->info('Total permissions attached: ' . $allPermissions->count());
    }
}
