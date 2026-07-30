<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Concerns\Package\HasAssets;
use Spatie\LaravelPackageTools\Concerns\Package\HasBladeComponents;
use Spatie\LaravelPackageTools\Concerns\Package\HasCommands;
use Spatie\LaravelPackageTools\Concerns\Package\HasConfigs;
use Spatie\LaravelPackageTools\Concerns\Package\HasInertia;
use Spatie\LaravelPackageTools\Concerns\Package\HasInstallCommand;
use Spatie\LaravelPackageTools\Concerns\Package\HasMigrations;
use Spatie\LaravelPackageTools\Concerns\Package\HasRoutes;
use Spatie\LaravelPackageTools\Concerns\Package\HasServiceProviders;
use Spatie\LaravelPackageTools\Concerns\Package\HasTranslations;
use Spatie\LaravelPackageTools\Concerns\Package\HasViewComposers;
use Spatie\LaravelPackageTools\Concerns\Package\HasViews;
use Spatie\LaravelPackageTools\Concerns\Package\HasViewSharedData;

class Package
{
    use HasAssets;
    use HasBladeComponents;
    use HasCommands;
    use HasConfigs;
    use HasInertia;
    use HasInstallCommand;
    use HasMigrations;
    use HasRoutes;
    use HasServiceProviders;
    use HasTranslations;
    use HasViewComposers;
    use HasViews;
    use HasViewSharedData;

    public string $name;

    public string $basePath;

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function shortName(): string
    {
        return Str::after($this->name, 'laravel-');
    }

    public function basePath(?string $directory = null): string
    {
        if ($directory === null) {
            return $this->basePath;
        }

        return $this->basePath . DIRECTORY_SEPARATOR . ltrim($directory, DIRECTORY_SEPARATOR);
    }

    public function setBasePath(string $path): static
    {
        $this->basePath = $path;

        return $this;
    }
}
