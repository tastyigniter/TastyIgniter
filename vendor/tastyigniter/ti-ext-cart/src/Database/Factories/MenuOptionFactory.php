<?php

declare(strict_types=1);

namespace Igniter\Cart\Database\Factories;

use Igniter\Cart\Models\MenuOption;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class MenuOptionFactory extends Factory
{
    protected $model = MenuOption::class;

    #[Override]
    public function definition(): array
    {
        return [
            'option_name' => $this->faker->word,
            'display_type' => $this->faker->randomElement(['select', 'radio', 'checkbox', 'quantity']),
        ];
    }
}
