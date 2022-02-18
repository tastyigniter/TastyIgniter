<?php

namespace Admin\Database\Factories;

use Admin\Models\Users_model;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = Users_model::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->userName,
            'date_activated' => time(),
            'is_activated' => TRUE,
            'super_user' => TRUE,
        ];
    }
}
