<?php

namespace System\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;

class MailLayoutFactory extends Factory
{
    protected $model = \System\Models\MailLayout::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'code' => $this->faker->slug(),
            'layout' => $this->faker->randomHtml(),
            'layout_css' => $this->faker->text(),
            'plain_layout' => $this->faker->text(),
            'is_locked' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
        ];
    }
}
