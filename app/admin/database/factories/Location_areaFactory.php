<?php

namespace Admin\Database\Factories;

use Admin\Models\Location_areas_model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Location_areaFactory extends Factory
{
    protected $model = Location_areas_model::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['address', 'circle', 'polygon']),
            'color' => $this->faker->hexcolor,
            'is_default' => $this->faker->boolean,
        ];
    }
}
