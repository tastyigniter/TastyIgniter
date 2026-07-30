<?php

declare(strict_types=1);

namespace Igniter\Local\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\Local\Models\Review;
use Override;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    #[Override]
    public function definition(): array
    {
        return [
            'location_id' => $this->faker->numberBetween(1, 200),
            'customer_id' => $this->faker->numberBetween(1, 200),
            'reviewable_id' => $this->faker->numberBetween(1, 200),
            'reviewable_type' => 'orders',
            'author' => $this->faker->name,
            'quality' => $this->faker->numberBetween(0, 6),
            'delivery' => $this->faker->numberBetween(0, 6),
            'service' => $this->faker->numberBetween(0, 6),
            'review_text' => $this->faker->text(),
            'review_status' => 1,
        ];
    }
}
