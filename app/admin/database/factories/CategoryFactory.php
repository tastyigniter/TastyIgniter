<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = \Admin\Models\Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(7),
            'priority' => $this->faker->numberBetween(1, 9999),
            'status' => $this->faker->boolean(),
        ];
    }
}
