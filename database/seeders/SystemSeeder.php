<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type_systems = ['Desktop', 'Mobile', 'Web'];

        foreach ($type_systems as $type_system) {
            System::factory()->create([
                'description' => $type_system,
            ]);
        }
    }
}
