<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class TableFactory extends Factory
{
    protected $model = \Admin\Models\Table::class;

    public function definition(): array
    {
        return [
            'table_name' => $this->faker->word(),
            'min_capacity' => $this->faker->randomDigitNotNull(),
            'max_capacity' => $this->faker->numberBetween(10, 99),
            'extra_capacity' => $this->faker->numberBetween(1, 999),
            'priority' => $this->faker->randomDigit(),
            'is_joinable' => $this->faker->boolean(),
            'table_status' => $this->faker->boolean(),
        ];
    }
}
