<?php

namespace Spatie\LaravelPackageTools\Commands\Concerns;

use Illuminate\Support\Str;

trait SupportsServiceProviderInApp
{
    protected bool $copyServiceProviderInApp = false;

    public function copyAndRegisterServiceProviderInApp(): self
    {
        $this->copyServiceProviderInApp = true;

        return $this;
    }

    protected function processCopyServiceProviderInApp(): self
    {
        if ($this->copyServiceProviderInApp) {
            $this->comment('Publishing service provider...');

            $this->copyServiceProviderInApp();
        }

        return $this;
    }

    protected function copyServiceProviderInApp(): self
    {
        $providerName = $this->package->publishableProviderName;

        if (! $providerName) {
            return $this;
        }

        $this->callSilent('vendor:publish', ['--tag' => $this->package->shortName() . '-provider']);

        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        if (intval(app()->version()) < 11 || ! file_exists(base_path('bootstrap/providers.php'))) {
            $appConfig = file_get_contents(config_path('app.php'));
        } else {
            $appConfig = file_get_contents(base_path('bootstrap/providers.php'));
        }

        $class = '\\Providers\\' . Str::replace('/', '\\', $providerName) . '::class';

        if (Str::contains($appConfig, $namespace . $class)) {
            return $this;
        }

        if (intval(app()->version()) < 11 || ! file_exists(base_path('bootstrap/providers.php'))) {
            file_put_contents(config_path('app.php'), str_replace(
                "{$namespace}\\Providers\\BroadcastServiceProvider::class,",
                "{$namespace}\\Providers\\BroadcastServiceProvider::class," . PHP_EOL . "        {$namespace}{$class},",
                $appConfig
            ));
        } else {
            file_put_contents(base_path('bootstrap/providers.php'), str_replace(
                "{$namespace}\\Providers\\AppServiceProvider::class,",
                "{$namespace}\\Providers\\AppServiceProvider::class," . PHP_EOL . "        {$namespace}{$class},",
                $appConfig
            ));
        }

        file_put_contents(app_path('Providers/' . $providerName . '.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/' . $providerName . '.php'))
        ));

        return $this;
    }
}
