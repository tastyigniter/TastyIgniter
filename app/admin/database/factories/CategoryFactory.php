<?php

namespace Admin\Database\Factories;

use Admin\Models\Categories_model;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Categories_model::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'permalink_slug' => $this->faker->slug(),
            'parent_id' => null,
            'priority' => null,
            'status' => $this->faker->boolean(),
            'locations' => [$this->faker->numberBetween(1, 50)],
        ];
    }
}
