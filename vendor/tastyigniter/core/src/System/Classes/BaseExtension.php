<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Facades\Igniter\System\Helpers\SystemHelper;
use Igniter\Flame\Providers\EventServiceProvider;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Console\Scheduling\Schedule;
use ReflectionClass;

/**
 * Base Extension Class
 */
abstract class BaseExtension extends EventServiceProvider
{
    protected ?array $config = null;

    /** Determine if this extension should be loaded (false) or not (true). */
    public bool $disabled = false;

    public function __construct($app)
    {
        $this->app = $app;
        $this->booting(function() {
            $this->bootingExtension();
        });
    }

    public function bootingExtension()
    {
        $reflector = new ReflectionClass(static::class);

        $config = SystemHelper::extensionValidateConfig($this->extensionMeta());

        $extensionPath = dirname($reflector->getFileName(), 2);
        $extensionNamespace = array_get($config, 'namespace', $namespace = $reflector->getNamespaceName().'\\');
        $extensionCode = array_get($config, 'code', str_replace('\\', '.', $namespace));

        // Register resources path symbol
        if (File::isDirectory($resourcesPath = $extensionPath.'/resources')) {
            Igniter::loadResourcesFrom($resourcesPath, $extensionCode);
        }

        if (File::isDirectory($langPath = $extensionPath.'/resources/lang')) {
            $this->loadTranslationsFrom($langPath, $extensionCode);
        }

        // Register migrations path
        if (File::isDirectory($migrationPath = $extensionPath.'/database/migrations')) {
            Igniter::loadMigrationsFrom($migrationPath, $extensionCode);
        }

        if ($this->disabled) {
            $this->app->bindMethod(static::class.'@boot', fn(): null => null);

            return null;
        }

        // Register controller path
        if (File::isDirectory($controllerPath = $extensionPath.'/src/Http/Controllers')) {
            Igniter::loadControllersFrom($controllerPath, $extensionNamespace.'Http\\Controllers');
        }

        // Register views path
        if (File::isDirectory($viewsPath = $extensionPath.'/views') ||
            File::isDirectory($viewsPath = $extensionPath.'/resources/views')) {
            $this->loadViewsFrom($viewsPath, $extensionCode);
        }

        // Add routes, if available
        if (File::exists($routesFile = $extensionPath.'/routes.php') ||
            File::exists($routesFile = $extensionPath.'/routes/routes.php') ||
            File::exists($routesFile = $extensionPath.'/routes/web.php')) {
            $this->loadRoutesFrom($routesFile);
        }

        return null;
    }

    /**
     * Returns information about this extension
     */
    public function extensionMeta(): array
    {
        if (func_get_args()) {
            return $this->config = func_get_arg(0);
        }

        if (!is_null($this->config)) {
            return $this->config;
        }

        return $this->config = SystemHelper::extensionConfigFromFile(dirname(File::fromClass(static::class)));
    }

    /**
     * Registers any front-end components implemented in this extension.
     * The components must be returned in the following format:
     * ['path/to/class' => ['code' => 'component_code']]
     */
    public function registerComponents(): array
    {
        return [];
    }

    /**
     * Registers any payment gateway implemented in this extension.
     * The payment gateway must be returned in the following format:
     * ['path/to/class' => 'alias']
     */
    public function registerPaymentGateways(): array
    {
        return [];
    }

    /**
     * Registers back-end navigation menu items for this extension.
     */
    public function registerNavigation(): array
    {
        return [];
    }

    /**
     * Registers any back-end permissions used by this extension.
     */
    public function registerPermissions(): array
    {
        return [];
    }

    /**
     * Registers the back-end setting links used by this extension.
     */
    public function registerSettings(): array
    {
        return [];
    }

    /**
     * Registers scheduled tasks that are executed on a regular basis.
     */
    public function registerSchedule(Schedule $schedule) {}

    /**
     * Registers any dashboard widgets provided by this extension.
     */
    public function registerDashboardWidgets(): array
    {
        return [];
    }

    /**
     * Registers any form widgets implemented in this extension.
     * The widgets must be returned in the following format:
     * ['className1' => 'alias'],
     * ['className2' => 'anotherAlias']
     */
    public function registerFormWidgets(): array
    {
        return [];
    }

    /**
     * Registers any mail templates implemented by this extension.
     * The templates must be returned in the following format:
     * [
     *  'igniter.demo::mail.registration' => 'Registration email to customer.',
     * ]
     * The array key will be used as the template code
     */
    public function registerMailTemplates(): array
    {
        return [];
    }

    /**
     * Registers a new console (artisan) command
     */
    public function registerConsoleCommand(string $key, string $class): void
    {
        $key = 'command.'.$key;

        $this->app->singleton($key, $class);

        $this->commands($key);
    }

    /**
     * Registers any validation rule implemented by this extension.
     * The widgets must be returned in the following format:
     * ['rule' => 'className1'],
     * ['rule' => 'className2']
     */
    public function registerValidationRules(): array
    {
        return [];
    }
}
