<?php

declare(strict_types=1);

namespace Igniter\Cart\Database\Factories;

use Igniter\Cart\Models\Mealtime;
use Igniter\Flame\Database\Factories\Factory;
use Override;

class MealtimeFactory extends Factory
{
    protected $model = Mealtime::class;

    #[Override]
    public function definition(): array
    {
        return [
            'mealtime_name' => $this->faker->sentence(2),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'validity' => 'daily',
            'mealtime_status' => true,
        ];
    }
}
