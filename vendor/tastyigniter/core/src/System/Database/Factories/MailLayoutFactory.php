<?php

declare(strict_types=1);

namespace Igniter\System\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\System\Models\MailLayout;
use Override;

class MailLayoutFactory extends Factory
{
    protected $model = MailLayout::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'code' => $this->faker->slug(),
            'language_id' => 1,
            'layout' => $this->faker->randomHtml(),
            'layout_css' => $this->faker->text(),
            'plain_layout' => $this->faker->text(),
            'is_locked' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
        ];
    }
}
