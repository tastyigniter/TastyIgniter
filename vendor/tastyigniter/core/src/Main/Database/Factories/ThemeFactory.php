<?php

declare(strict_types=1);

namespace Igniter\Main\Database\Factories;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\Main\Models\Theme;
use Illuminate\Database\Eloquent\Model;
use Override;

class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'code' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'version' => $this->faker->semver(),
            'data' => [],
            'status' => true,
            'is_default' => false,
        ];
    }

    public function findOrCreateTestTheme($attributes = []): Model|Theme
    {
        return Theme::query()->firstOrCreate(
            ['code' => 'tests-theme'],
            array_merge($this->definition(), ['name' => 'Theme Name', 'code' => 'tests-theme'], $attributes)
        );
    }
}
