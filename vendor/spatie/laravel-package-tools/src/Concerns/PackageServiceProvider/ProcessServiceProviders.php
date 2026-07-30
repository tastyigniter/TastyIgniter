<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessServiceProviders
{
    protected function bootPackageServiceProviders(): self
    {
        if (! $this->package->publishableProviderName || ! $this->app->runningInConsole()) {
            return $this;
        }

        $providerName = $this->package->publishableProviderName;
        $vendorProvider = $this->package->basePath("/../resources/stubs/{$providerName}.php.stub");
        $appProvider = base_path("app/Providers/{$providerName}.php");

        $this->publishes([$vendorProvider => $appProvider], "{$this->package->shortName()}-provider");

        return $this;
    }
}
