<?php

declare(strict_types=1);

namespace Igniter\User\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\System\Models\Country;
use Igniter\User\Models\Address;
use Override;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    #[Override]
    public function definition(): array
    {
        return [
            'address_1' => $this->faker->streetAddress,
            'address_2' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'postcode' => $this->faker->postcode,
            'country_id' => Country::factory(),
        ];
    }
}
