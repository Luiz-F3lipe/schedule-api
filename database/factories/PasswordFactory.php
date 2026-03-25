<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Password;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Password>
 */
class PasswordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => null,
            'product_id'    => null,
            'description'   => $this->faker->sentence(),
            'password'      => $this->faker->password(),
            'observation'   => $this->faker->paragraph(),
        ];
    }
}
