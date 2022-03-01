<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class LocationAreaFactory extends Factory
{
    protected $model = \Admin\Models\LocationArea::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(['address', 'circle', 'polygon']),
            'color' => $this->faker->hexColor(),
            'is_default' => $this->faker->boolean(),
        ];
    }
}
