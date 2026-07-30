<?php

declare(strict_types=1);

namespace Igniter\Cart\Database\Factories;

use Igniter\Cart\Models\Category;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(),
            'priority' => $this->faker->randomDigit(),
            'status' => 1,
        ];
    }
}
