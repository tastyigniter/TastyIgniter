<?php

declare(strict_types=1);

namespace Igniter\Api\Database\Factories;

use Igniter\Api\Models\Token;
use Igniter\Flame\Database\Factories\Factory;

class TokenFactory extends Factory
{
    protected $model = Token::class;

    public function definition(): array
    {
        return [
            'tokenable_type' => 'users',
            'tokenable_id' => 1,
            'name' => $this->faker->sentence(2),
            'token' => $this->faker->sha256,
            'abilities' => ['*'],
        ];
    }
}
