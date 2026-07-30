<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessRoutes
{
    protected function bootPackageRoutes(): self
    {
        if (empty($this->package->routeFileNames)) {
            return $this;
        }

        foreach ($this->package->routeFileNames as $routeFileName) {
            $this->loadRoutesFrom("{$this->package->basePath('/../routes/')}{$routeFileName}.php");
        }

        return $this;
    }
}
