<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class UserRoleFactory extends Factory
{
    protected $model = \Admin\Models\UserRole::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->slug(3),
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(),
            'permissions' => [$this->faker->numberBetween(1, 99)],
        ];
    }
}
