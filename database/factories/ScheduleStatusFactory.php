<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\ScheduleStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScheduleStatus>
 */
class ScheduleStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->unique()->word(),
            'color'       => $this->faker->hexColor(),
            'active'      => $this->faker->boolean(),
        ];
    }
}
