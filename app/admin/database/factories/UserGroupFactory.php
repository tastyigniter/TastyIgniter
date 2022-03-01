<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class UserGroupFactory extends Factory
{
    protected $model = \Admin\Models\UserGroup::class;

    public function definition(): array
    {
        return [
            'user_group_name' => $this->faker->word(),
            'description' => $this->faker->sentence(5),
            'auto_assign' => $this->faker->boolean(),
            'auto_assign_mode' => $this->faker->numberBetween(0, 3),
            'auto_assign_limit' => $this->faker->numberBetween(2, 50),
            'auto_assign_availability' => $this->faker->boolean(),
        ];
    }
}
