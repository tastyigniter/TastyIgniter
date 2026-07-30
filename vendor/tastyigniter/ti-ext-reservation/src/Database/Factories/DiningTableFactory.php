<?php

declare(strict_types=1);

namespace Igniter\Reservation\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\Reservation\Models\DiningTable;
use Override;

class DiningTableFactory extends Factory
{
    protected $model = DiningTable::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'min_capacity' => $this->faker->randomDigitNotNull(),
            'max_capacity' => $this->faker->numberBetween(10, 20),
            'priority' => $this->faker->randomDigit(),
            'is_enabled' => 1,
        ];
    }
}
