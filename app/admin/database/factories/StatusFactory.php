<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class StatusFactory extends Factory
{
    protected $model = \Admin\Models\Status::class;

    public function definition(): array
    {
        return [
            'status_name' => $this->faker->word(),
            'status_for' => $this->faker->randomElement(['order', 'reservation']),
            'status_color' => $this->faker->hexColor(),
            'status_comment' => $this->faker->paragraph(),
            'notify_customer' => $this->faker->boolean(),
        ];
    }
}
