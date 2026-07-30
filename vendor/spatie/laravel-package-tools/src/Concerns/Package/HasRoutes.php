<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasRoutes
{
    public array $routeFileNames = [];

    public function hasRoute(string $routeFileName): static
    {
        $this->routeFileNames[] = $routeFileName;

        return $this;
    }

    public function hasRoutes(...$routeFileNames): static
    {
        $this->routeFileNames = array_merge(
            $this->routeFileNames,
            collect($routeFileNames)->flatten()->toArray()
        );

        return $this;
    }
}
