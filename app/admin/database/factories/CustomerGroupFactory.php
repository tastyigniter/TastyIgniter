<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class CustomerGroupFactory extends Factory
{
    protected $model = \Admin\Models\CustomerGroup::class;

    public function definition(): array
    {
        return [
            'group_name' => $this->faker->word(),
            'description' => $this->faker->sentence(7),
            'approval' => $this->faker->boolean(),
        ];
    }
}
