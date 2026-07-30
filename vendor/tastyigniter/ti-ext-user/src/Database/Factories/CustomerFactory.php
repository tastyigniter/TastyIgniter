<?php

declare(strict_types=1);

namespace Igniter\User\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\User\Models\Customer;
use Override;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    #[Override]
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'telephone' => $this->faker->phoneNumber(),
            'newsletter' => $this->faker->boolean(),
            'address_id' => $this->faker->numberBetween(1, 9999),
            'customer_group_id' => $this->faker->numberBetween(1, 9999),
            'status' => true,
            'is_activated' => $this->faker->boolean(),
            'ip_address' => $this->faker->ipv6(),
        ];
    }
}
