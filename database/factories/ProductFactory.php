<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\System;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'system_id'   => System::factory(),
            'description' => $this->faker->text(50),
        ];
    }
}
