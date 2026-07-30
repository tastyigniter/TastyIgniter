<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasViews
{
    public bool $hasViews = false;

    public ?string $viewNamespace = null;

    public function hasViews(?string $namespace = null): static
    {
        $this->hasViews = true;

        $this->viewNamespace = $namespace;

        return $this;
    }

    public function viewNamespace(): string
    {
        return $this->viewNamespace ?? $this->shortName();
    }
}
