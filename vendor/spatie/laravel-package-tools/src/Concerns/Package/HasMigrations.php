<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasMigrations
{
    public bool $runsMigrations = false;

    public bool $discoversMigrations = false;

    public ?string $migrationsPath = null;

    public array $migrationFileNames = [];

    public function runsMigrations(bool $runsMigrations = true): static
    {
        $this->runsMigrations = $runsMigrations;

        return $this;
    }

    public function hasMigration(string $migrationFileName): static
    {
        $this->migrationFileNames[] = $migrationFileName;

        return $this;
    }

    public function hasMigrations(...$migrationFileNames): static
    {
        $this->migrationFileNames = array_merge(
            $this->migrationFileNames,
            collect($migrationFileNames)->flatten()->toArray()
        );

        return $this;
    }

    public function discoversMigrations(bool $discoversMigrations = true, string $path = '/database/migrations'): static
    {
        $this->discoversMigrations = $discoversMigrations;
        $this->migrationsPath = $path;

        return $this;
    }
}
