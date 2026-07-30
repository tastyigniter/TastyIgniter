<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessTranslations
{
    protected function bootPackageTranslations(): self
    {
        if (! $this->package->hasTranslations) {
            return $this;
        }

        $vendorTranslations = $this->package->basePath('/../resources/lang');
        $appTranslations = (function_exists('lang_path'))
            ? lang_path("vendor/{$this->package->shortName()}")
            : resource_path("lang/vendor/{$this->package->shortName()}");

        $this->loadTranslationsFrom($vendorTranslations, $this->package->shortName());

        $this->loadJsonTranslationsFrom($vendorTranslations);
        $this->loadJsonTranslationsFrom($appTranslations);

        if ($this->app->runningInConsole()) {
            $this->publishes(
                [$vendorTranslations => $appTranslations],
                "{$this->package->shortName()}-translations"
            );
        }

        return $this;
    }
}
