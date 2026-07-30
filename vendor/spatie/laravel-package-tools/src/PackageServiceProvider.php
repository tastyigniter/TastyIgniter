<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessAssets;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessBladeComponents;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessCommands;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessConfigs;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessInertia;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessMigrations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessRoutes;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessServiceProviders;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessTranslations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViewComposers;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViews;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViewSharedData;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

abstract class PackageServiceProvider extends ServiceProvider
{
    use ProcessAssets;
    use ProcessBladeComponents;
    use ProcessCommands;
    use ProcessConfigs;
    use ProcessInertia;
    use ProcessMigrations;
    use ProcessRoutes;
    use ProcessServiceProviders;
    use ProcessTranslations;
    use ProcessViewComposers;
    use ProcessViews;
    use ProcessViewSharedData;

    protected Package $package;

    abstract public function configurePackage(Package $package): void;

    /** @throws InvalidPackage */
    public function register()
    {
        $this->registeringPackage();

        $this->package = $this->newPackage();
        $this->package->setBasePath($this->getPackageBaseDir());

        $this->configurePackage($this->package);
        if (empty($this->package->name)) {
            throw InvalidPackage::nameIsRequired();
        }

        $this->registerPackageConfigs();

        $this->packageRegistered();

        return $this;
    }

    public function registeringPackage()
    {
    }

    public function newPackage(): Package
    {
        return new Package();
    }

    public function packageRegistered()
    {
    }

    public function boot()
    {
        $this->bootingPackage();

        $this
            ->bootPackageAssets()
            ->bootPackageBladeComponents()
            ->bootPackageCommands()
            ->bootPackageConsoleCommands()
            ->bootPackageConfigs()
            ->bootPackageInertia()
            ->bootPackageMigrations()
            ->bootPackageRoutes()
            ->bootPackageServiceProviders()
            ->bootPackageTranslations()
            ->bootPackageViews()
            ->bootPackageViewComposers()
            ->bootPackageViewSharedData()
            ->packageBooted();

        return $this;
    }

    public function bootingPackage()
    {
    }

    public function packageBooted()
    {
    }

    protected function getPackageBaseDir(): string
    {
        $reflector = new ReflectionClass(get_class($this));

        $packageBaseDir = dirname($reflector->getFileName());

        // Some packages like to keep Laravels directory structure and place
        // the service providers in a Providers folder.
        // move up a level when this is the case.
        if (str_ends_with($packageBaseDir, DIRECTORY_SEPARATOR.'Providers')) {
            $packageBaseDir = dirname($packageBaseDir);
        }

        return $packageBaseDir;
    }

    public function packageView(?string $namespace): ?string
    {
        return is_null($namespace)
            ? $this->package->shortName()
            : $this->package->viewNamespace;
    }
}
