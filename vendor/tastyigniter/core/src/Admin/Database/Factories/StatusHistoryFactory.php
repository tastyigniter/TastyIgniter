<?php

declare(strict_types=1);

namespace Igniter\Admin\Database\Factories;

use Igniter\Admin\Models\StatusHistory;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class StatusHistoryFactory extends Factory
{
    protected $model = StatusHistory::class;

    #[Override]
    public function definition(): array
    {
        return [
            'object_id' => $this->faker->numberBetween(1, 9999),
            'object_type' => $this->faker->randomElement(['order', 'reservation']),
            'user_id' => $this->faker->numberBetween(1, 9999),
            'status_id' => $this->faker->numberBetween(1, 9999),
            'notify' => $this->faker->boolean(),
            'comment' => $this->faker->paragraph(),
        ];
    }
}
