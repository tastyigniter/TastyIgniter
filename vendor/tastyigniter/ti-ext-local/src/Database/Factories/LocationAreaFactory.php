<?php

declare(strict_types=1);

namespace Igniter\Local\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\Local\Models\LocationArea;
use Override;

class LocationAreaFactory extends Factory
{
    protected $model = LocationArea::class;

    #[Override]
    public function definition(): array
    {
        $data = [
            'name' => $this->faker->sentence(2),
            'type' => $this->faker->randomElement(['address', 'circle', 'polygon']),
            'color' => $this->faker->hexColor(),
            'is_default' => $this->faker->boolean(),
        ];
        if($data['type'] !== 'address') {
            $data['boundaries'] = [
                'circle' => json_encode([
                    'lat' => $this->faker->latitude(),
                    'lng' => $this->faker->longitude(),
                    'radius' => $this->faker->numberBetween(1, 100),
                ]),
                'polygon' => '}a}~HpewHhf@??l_Aif@?',
                'vertices' => json_encode([
                    [
                        'lat' => $this->faker->latitude(),
                        'lng' => $this->faker->longitude(),
                    ],
                    [
                        'lat' => $this->faker->latitude(),
                        'lng' => $this->faker->longitude(),
                    ],
                ]),
            ];
        }

        return $data;
    }
}
