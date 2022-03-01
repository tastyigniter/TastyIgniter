<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class StatusFactory extends Factory
{
    protected $model = \Admin\Models\Status::class;

    public function definition(): array
    {
        return [
            'status_name' => $this->faker->lexify('???'),
            'status_for' => $this->faker->randomElement(['order', 'reservation']),
            'status_color' => $this->faker->hexcolor(),
            'status_comment' => $this->faker->sentence(),
            'notify_customer' => $this->faker->boolean(),
        ];
    }
}
