<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = \Admin\Models\User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'username' => $this->faker->userName,
            'date_activated' => time(),
            'is_activated' => TRUE,
            'super_user' => TRUE,
            'status' => TRUE,
        ];
    }
}
