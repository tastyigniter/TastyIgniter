<?php

namespace System\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class CurrencyFactory extends Factory
{
    protected $model = \System\Models\Currency::class;

    public function definition(): array
    {
        return [
            'currency_name' => $this->faker->word(),
            'currency_code' => $this->faker->lexify('???'),
            'currency_symbol' => '&pound;',
            'country_id' => 1,
            'symbol_position' => $this->faker->lexify('?'),
            'currency_rate' => 1,
            'thousand_sign' => $this->faker->lexify('?'),
            'decimal_sign' => '.',
            'decimal_position' => $this->faker->numerify('#'),
            'currency_status' => $this->faker->boolean(),
        ];
    }
}
