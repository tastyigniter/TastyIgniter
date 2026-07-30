<?php

declare(strict_types=1);

namespace Igniter\Coupons\Database\Factories;

use Igniter\Coupons\Models\Coupon;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'code' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'type' => 'P',
            'discount' => $this->faker->randomFloat(2, 1, 100),
            'status' => 1,
            'validity' => 'forever',
        ];
    }
}
