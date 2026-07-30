<?php

declare(strict_types=1);

namespace Igniter\System\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\System\Models\Country;
use Override;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    #[Override]
    public function definition(): array
    {
        return [
            'country_name' => $this->faker->sentence(2),
            'iso_code_2' => $this->faker->lexify('??'),
            'iso_code_3' => $this->faker->countryISOAlpha3(),
            'priority' => $this->faker->randomDigit(),
            'status' => true,
        ];
    }
}
