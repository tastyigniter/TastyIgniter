<?php

namespace System\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = \System\Models\Country::class;

    public function definition(): array
    {
        return [
            'country_name' => $this->faker->word(),
            'iso_code_2' => $this->faker->lexify('??'),
            'iso_code_3' => $this->faker->countryISOAlpha3(),
            'format' => "{address_1}\n{address_2}\n{city} {postcode}\n{country}",
            'priority' => $this->faker->randomDigit(),
            'status' => $this->faker->boolean(),
        ];
    }
}
