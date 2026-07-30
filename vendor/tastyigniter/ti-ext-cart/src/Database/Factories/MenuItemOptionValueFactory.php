<?php

declare(strict_types=1);

namespace Igniter\Cart\Database\Factories;

use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class MenuItemOptionValueFactory extends Factory
{
    protected $model = MenuItemOptionValue::class;

    #[Override]
    public function definition(): array
    {
        return [
            'menu_option_id' => $this->faker->randomNumber(8),
            'option_value_id' => $this->faker->randomNumber(8),
        ];
    }
}
