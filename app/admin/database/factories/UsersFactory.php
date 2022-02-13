<?php

namespace Admin\Database\Factories;

use Admin\Models\Users_model;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsersFactory extends Factory
{
    protected $model = Users_model::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->text(32),
            'date_activated' => time(),
            'is_activated' => true,
            'super_user' => true,
        ];
    }
}
