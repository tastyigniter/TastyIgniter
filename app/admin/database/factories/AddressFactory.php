<?php

namespace Admin\Database\Factories;

use Admin\Models\Addresses_model;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Addresses_model::class;

    public function definition(): array
    {
        return [
            'address_1' => $this->faker->streetAddress,
            'address_2' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postcode' => $this->faker->postcode,
            'country_id' => 1,
        ];
    }
}
