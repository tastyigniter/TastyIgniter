<?php

namespace Admin\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = \Admin\Models\Customer::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'telephone' => $this->faker->phoneNumber(),
            'newsletter' => $this->faker->boolean(),
            'address_id' => $this->faker->numberBetween(1, 9999),
            'customer_group_id' => $this->faker->numberBetween(1, 9999),
            'is_activated' => $this->faker->boolean(),
            'ip_address' => $this->faker->ipv6(),
        ];
    }
}
