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
            'description' => $this->faker->paragraph(),
            'priority' => $this->faker->randomDigit(),
            'status' => $this->faker->boolean(),
        ];
    }
}
