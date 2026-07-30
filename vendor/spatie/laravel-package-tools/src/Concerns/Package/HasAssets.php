<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasAssets
{
    public bool $hasAssets = false;

    public function hasAssets(): static
    {
        $this->hasAssets = true;

        return $this;
    }
}
