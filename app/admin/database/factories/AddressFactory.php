<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = \Admin\Models\Address::class;

    public function definition(): array
    {
        return [
            'address_1' => $this->faker->streetAddress,
            'address_2' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postcode' => $this->faker->postcode,
            'country_id' => $this->faker->numberBetween(1, 999),
        ];
    }
}
