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
            'username' => str_slug($this->faker->userName()),
            'date_activated' => $this->faker->dateTime(),
            'is_activated' => $this->faker->boolean(),
            'super_user' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
        ];
    }
}
