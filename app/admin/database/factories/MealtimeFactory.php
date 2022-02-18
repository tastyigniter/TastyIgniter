<?php

namespace Admin\Database\Factories;

use Admin\Models\Mealtimes_model;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealtimeFactory extends Factory
{
    protected $model = Mealtimes_model::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'mealtime_status' => $this->faker->boolean(),
        ];
    }
}
