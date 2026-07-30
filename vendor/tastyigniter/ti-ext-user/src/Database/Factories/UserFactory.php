<?php

declare(strict_types=1);

namespace Igniter\User\Database\Factories;

use DateTimeInterface;
use Igniter\Flame\Database\Factories\Factory;
use Igniter\User\Models\User;
use Override;

class UserFactory extends Factory
{
    protected $model = User::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'username' => str_slug($this->faker->userName()),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'activated_at' => $this->faker->dateTime()->format(DateTimeInterface::ATOM),
            'is_activated' => $this->faker->boolean(),
            'super_user' => false,
            'status' => $this->faker->boolean(),
        ];
    }

    public function superUser(): self
    {
        return $this->state(fn(array $attributes): array => [
            'is_activated' => true,
            'status' => true,
            'super_user' => true,
        ]);
    }
}
