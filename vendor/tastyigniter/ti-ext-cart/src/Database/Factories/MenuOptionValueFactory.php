<?php

declare(strict_types=1);

namespace Igniter\Cart\Database\Factories;

use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class MenuOptionValueFactory extends Factory
{
    protected $model = MenuOptionValue::class;

    #[Override]
    public function definition(): array
    {
        return [
            'option_id' => $this->faker->randomNumber(8),
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
