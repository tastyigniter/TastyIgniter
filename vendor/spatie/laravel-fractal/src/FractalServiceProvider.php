<?php

namespace Spatie\Fractal;

use Illuminate\Support\Collection;
use Spatie\Fractal\Console\Commands\TransformerMakeCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FractalServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-fractal')
            ->hasConfigFile()
            ->hasCommand(TransformerMakeCommand::class);
    }

    public function packageBooted()
    {
        Collection::macro('transformWith', function ($transformer) {
            return fractal($this, $transformer);
        });
    }

    public function packageRegistered()
    {
        $this->app->singleton('fractal', function ($app, $arguments) {
            return fractal(...$arguments);
        });

        $this->app->alias('fractal', Fractal::class);
    }
}
