<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasBladeComponents
{
    public array $viewComponents = [];

    public function hasViewComponent(string $prefix, string $viewComponentName): static
    {
        $this->viewComponents[$viewComponentName] = $prefix;

        return $this;
    }

    public function hasViewComponents(string $prefix,  ...$viewComponentNames): static
    {
        foreach ($viewComponentNames as $componentName) {
            $this->viewComponents[$componentName] = $prefix;
        }

        return $this;
    }
}
