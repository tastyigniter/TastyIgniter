<?php

namespace System\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class LanguageFactory extends Factory
{
    protected $model = \System\Models\Language::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'code' => $this->faker->languageCode(),
            'status' => $this->faker->boolean(),
        ];
    }
}
