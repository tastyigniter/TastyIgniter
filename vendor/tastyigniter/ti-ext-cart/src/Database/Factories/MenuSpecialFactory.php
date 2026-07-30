<?php

declare(strict_types=1);

namespace Igniter\Cart\Database\Factories;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuSpecial;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class MenuSpecialFactory extends Factory
{
    protected $model = MenuSpecial::class;

    #[Override]
    public function definition(): array
    {
        return [
            'menu_id' => Menu::factory(),
            'special_price' => $this->faker->randomFloat(),
            'type' => 'F',
            'validity' => 'forever',
            'special_status' => 1,
        ];
    }
}
