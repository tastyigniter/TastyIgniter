<?php

declare(strict_types=1);

namespace Igniter\Reservation\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\Reservation\Models\DiningSection;
use Override;

class DiningSectionFactory extends Factory
{
    protected $model = DiningSection::class;

    #[Override]
    public function definition(): array
    {
        return [
            'location_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(5),
            'priority' => $this->faker->randomDigit(),
            'is_enabled' => 1,
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
