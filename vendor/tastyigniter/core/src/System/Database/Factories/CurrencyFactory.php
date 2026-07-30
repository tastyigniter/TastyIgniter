<?php

declare(strict_types=1);

namespace Igniter\System\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\System\Models\Currency;
use Override;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    #[Override]
    public function definition(): array
    {
        return [
            'currency_name' => $this->faker->sentence(2),
            'currency_code' => $this->faker->currencyCode(),
            'currency_symbol' => '£',
            'country_id' => 1,
            'symbol_position' => 0,
            'currency_rate' => $this->faker->randomFloat(4, 0, 10),
            'thousand_sign' => ',',
            'decimal_sign' => '.',
            'decimal_position' => 2,
            'currency_status' => true,
        ];
    }
}
