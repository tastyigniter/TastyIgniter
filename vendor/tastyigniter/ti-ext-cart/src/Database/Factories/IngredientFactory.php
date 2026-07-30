<?php

declare(strict_types=1);

namespace Igniter\Cart\Database\Factories;

use Igniter\Cart\Models\Ingredient;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    #[Override]
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
