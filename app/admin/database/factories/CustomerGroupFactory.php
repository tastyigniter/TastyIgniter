<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class CustomerGroupFactory extends Factory
{
    protected $model = \Admin\Models\CustomerGroup::class;

    public function definition(): array
    {
        return [
            'group_name' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(),
            'approval' => $this->faker->boolean(),
        ];
    }
}
