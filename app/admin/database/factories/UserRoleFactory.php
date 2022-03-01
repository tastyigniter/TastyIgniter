<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class UserRoleFactory extends Factory
{
    protected $model = \Admin\Models\UserRole::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'permissions' => [$this->faker->numberBetween(1, 99)],
        ];
    }
}
