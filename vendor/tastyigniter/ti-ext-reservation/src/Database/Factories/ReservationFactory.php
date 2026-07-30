<?php

declare(strict_types=1);

namespace Igniter\Reservation\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\Reservation;
use Override;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    #[Override]
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'telephone' => $this->faker->phoneNumber(),
            'reserve_date' => $this->faker->date(),
            'reserve_time' => $this->faker->time(),
            'guest_num' => $this->faker->numberBetween(0, 99),
            'location_id' => Location::factory(),
        ];
    }
}
