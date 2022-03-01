<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = \Admin\Models\Menu::class;

    public function definition(): array
    {
        return [
            'menu_name' => $this->faker->sentence(2),
            'menu_price' => $this->faker->randomFloat(),
            'minimum_qty' => $this->faker->numberBetween(2, 500),
        ];
    }
}
