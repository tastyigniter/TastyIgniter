<?php

declare(strict_types=1);

namespace Igniter\Cart\Database\Factories;

use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuOption;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class MenuItemOptionFactory extends Factory
{
    protected $model = MenuItemOption::class;

    #[Override]
    public function definition(): array
    {
        return [
            'option_id' => MenuOption::factory(),
            'menu_id' => $this->faker->randomNumber(8),
            'is_required' => $this->faker->boolean,
            'min_selected' => 0,
            'max_selected' => 0,
        ];
    }
}
