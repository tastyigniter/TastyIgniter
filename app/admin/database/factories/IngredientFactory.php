<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = \Admin\Models\Ingredient::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(),
            'is_allergen' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
        ];
    }
}
