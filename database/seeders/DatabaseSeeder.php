<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Permission;
use App\Models\Product;
use App\Models\System;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed permissions first
        $this->call(PermissionSeeder::class);

        // Create default departments
        $default_departments = [
            'Desenvolvimento',
            'Financeiro',
            'Implantação',
            'Suporte',
            'Diretoria',
            'Comercial',
            'Administrador',
        ];

        $departments = [];

        foreach ($default_departments as $department) {
            $departments[] = Department::factory()->create([
                'description' => $department,
                'active'      => true,
            ]);
        }

        // Assign permissions to departments
        $adminDepartment   = Department::where('description', 'Administrador')->first();
        $devDepartment     = Department::where('description', 'Desenvolvimento')->first();
        $supportDepartment = Department::where('description', 'Suporte')->first();

        // Admin gets all permissions
        if ($adminDepartment) {
            $allPermissions = Permission::all();
            $adminDepartment->permissions()->attach($allPermissions->pluck('id'));
        }

        // Dev gets permissions for all resources except user management
        if ($devDepartment) {
            $devPermissions = Permission::whereIn('resource', ['department', 'product', 'schedule_status', 'system', 'schedule', 'password'])
                ->get();
            $devDepartment->permissions()->attach($devPermissions->pluck('id'));
        }

        // Support gets only list and show permissions
        if ($supportDepartment) {
            $supportPermissions = Permission::whereIn('action', ['list', 'show'])->get();
            $supportDepartment->permissions()->attach($supportPermissions->pluck('id'));
        }

        // Create a test user
        User::factory()->create([
            'department_id' => $departments[0]->id, // Assign to the first department
            'name'          => 'Test User',
            'email'         => 'test@example.com',
        ]);

        // Create default system
        $type_systems = ['Desktop', 'Mobile', 'Web'];

        foreach ($type_systems as $type_system) {
            System::factory()->create([
                'description' => $type_system,
            ]);
        }

        // Create products and associate with systems
        $products = [
            ['system' => 'Desktop', 'product' => 'Solution'],
            ['system' => 'Desktop', 'product' => 'Smallpack'],
            ['system' => 'Desktop', 'product' => 'Atacado'],
            ['system' => 'Desktop', 'product' => 'Visual-Align'],
            ['system' => 'Desktop', 'product' => 'Customizados'],
            ['system' => 'Mobile', 'product' => 'Conexpack'],
            ['system' => 'Mobile', 'product' => 'Conexpack Service'],
            ['system' => 'Mobile', 'product' => 'App Inventario'],
            ['system' => 'Mobile', 'product' => 'Transul'],
            ['system' => 'Mobile', 'product' => 'ConexStore'],
            ['system' => 'Web', 'product' => 'Trez'],
            ['system' => 'Web', 'product' => 'Side'],
            ['system' => 'Web', 'product' => 'Cash'],
            ['system' => 'Web', 'product' => 'Sincoval'],
            ['system' => 'Web', 'product' => 'Aluguel'],
            ['system' => 'Web', 'product' => 'Caixa Delsi'],
            ['system' => 'Web', 'product' => 'Transpinus Web'],
            ['system' => 'Web', 'product' => 'Rxpack'],
            ['system' => 'Web', 'product' => 'Paequere Web'],
        ];

        foreach ($products as $product) {
            $system = System::where('description', $product['system'])->first();

            if ($system) {
                Product::factory()->create([
                    'system_id'   => $system->id,
                    'description' => $product['product'],
                ]);
            }
        }
    }
}
