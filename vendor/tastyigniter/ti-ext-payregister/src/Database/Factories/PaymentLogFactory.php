<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\PayRegister\Models\PaymentLog;
use Override;

class PaymentLogFactory extends Factory
{
    protected $model = PaymentLog::class;

    #[Override]
    public function definition(): array
    {
        return [
            'message' => $this->faker->sentence,
            'payment_code' => $this->faker->word,
            'payment_name' => $this->faker->name,
            'is_success' => true,
            'request' => [],
            'response' => [],
            'is_refundable' => false,
        ];
    }
}
