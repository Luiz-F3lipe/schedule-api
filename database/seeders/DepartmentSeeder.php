<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_departments = [
            'Desenvolvimento',
            'Financeiro',
            'Implantação',
            'Suporte',
            'Diretoria',
            'Comercial',
        ];

        foreach ($default_departments as $department) {
            Department::factory()->create([
                'description' => $department,
                'active'      => true,
            ]);
        }
    }
}
