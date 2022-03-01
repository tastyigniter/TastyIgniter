<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class UserGroupFactory extends Factory
{
    protected $model = \Admin\Models\UserGroup::class;

    public function definition(): array
    {
        return [
            'user_group_name' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(),
            'auto_assign' => TRUE,
            'auto_assign_mode' => $this->faker->randomElement([1, 2]),
            'auto_assign_limit' => $this->faker->numberBetween(2, 50),
            'auto_assign_availability' => $this->faker->boolean(),
        ];
    }
}
