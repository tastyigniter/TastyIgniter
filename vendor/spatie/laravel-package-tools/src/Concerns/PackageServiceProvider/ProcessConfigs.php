<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessConfigs
{
    public function registerPackageConfigs(): self
    {
        if (empty($this->package->configFileNames)) {
            return $this;
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $configFilePath = $this->normalizeConfigPath($configFileName);
            $vendorConfig = $this->package->basePath("/../config/{$configFilePath}.php");

            // Only mergeConfigFile if a .php file and not if a stub file
            if (! is_file($vendorConfig)) {
                continue;
            }

            $normalizedConfigKey = $this->normalizeConfigKey($configFileName);
            $this->mergeConfigFrom($vendorConfig, $normalizedConfigKey);
        }

        return $this;
    }

    protected function bootPackageConfigs(): self
    {
        if (empty($this->package->configFileNames) || ! $this->app->runningInConsole()) {
            return $this;
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $configFilePath = $this->normalizeConfigPath($configFileName);

            $vendorConfig ;
            if (
                ! is_file($vendorConfig = $this->package->basePath("/../config/{$configFilePath}.php"))
                &&
                ! is_file($vendorConfig = $this->package->basePath("/../config/{$configFilePath}.php.stub"))
            ) {
                continue;
            }

            $this->publishes(
                [$vendorConfig => config_path("{$configFilePath}.php")],
                "{$this->package->shortName()}-config"
            );
        }

        return $this;
    }

    protected function normalizeConfigKey(string $configFileName): string
    {
        return str_replace(['/', '\\'], '.', $configFileName);
    }

    protected function normalizeConfigPath(string $configFileName): string
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $configFileName);
    }
}
