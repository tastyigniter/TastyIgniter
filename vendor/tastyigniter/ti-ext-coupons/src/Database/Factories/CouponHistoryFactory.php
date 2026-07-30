<?php

declare(strict_types=1);

namespace Igniter\Coupons\Database\Factories;

use Igniter\Coupons\Models\CouponHistory;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class CouponHistoryFactory extends Factory
{
    protected $model = CouponHistory::class;

    #[Override]
    public function definition(): array
    {
        return [
            'coupon_id' => $this->faker->randomDigitNotNull,
            'order_id' => $this->faker->randomDigitNotNull,
            'customer_id' => $this->faker->randomDigitNotNull,
            'min_total' => $this->faker->randomFloat(2, 1, 100),
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'status' => $this->faker->boolean,
        ];
    }
}
