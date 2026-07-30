<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Tests\Payments\Fixtures\TestPayment;
use Override;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'code' => $this->faker->word,
            'class_name' => TestPayment::class,
            'description' => $this->faker->text,
            'data' => [],
            'priority' => $this->faker->randomNumber(),
            'status' => 1,
        ];
    }
}
