<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class MealtimeFactory extends Factory
{
    protected $model = \Admin\Models\Mealtime::class;

    public function definition(): array
    {
        return [
            'mealtime_name' => $this->faker->sentence(2),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'mealtime_status' => $this->faker->boolean(),
        ];
    }
}
