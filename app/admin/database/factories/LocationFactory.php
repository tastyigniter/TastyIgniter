<?php

namespace Admin\Database\Factories;

use Admin\Models\Locations_model;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Locations_model::class;

    public function definition(): array
    {
        return [
            'location_name' => $this->faker->text(32),
            'location_email' => $this->faker->email,
            'location_address_1' => $this->faker->streetAddress,
            'location_country_id' => $this->faker->numberBetween(1, 200),
            'location_lat' => $this->faker->latitude,
            'location_lng' => $this->faker->longitude,
            'options' => [
                'auto_lat_lng' => FALSE,
            ],
        ];
    }
}
