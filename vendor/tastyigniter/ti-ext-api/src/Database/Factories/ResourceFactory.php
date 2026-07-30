<?php

declare(strict_types=1);

namespace Igniter\Api\Database\Factories;

use Igniter\Api\Models\Resource;
use Igniter\Flame\Database\Factories\Factory;

class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'endpoint' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'meta' => [
                'actions' => ['index', 'show', 'store', 'update', 'destroy'],
                'authorization' => [
                    'index' => 'all',
                    'show' => 'admin',
                    'store' => 'admin',
                    'update' => 'admin',
                    'destroy' => 'admin',
                ],
            ],
        ];
    }
}
