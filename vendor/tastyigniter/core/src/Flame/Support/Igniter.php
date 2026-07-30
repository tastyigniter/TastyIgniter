<?php

declare(strict_types=1);

namespace Igniter\Flame\Support;

use Exception;
use Igniter\Flame\Filesystem\Filesystem;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\View\Factory;

class Igniter
{
    protected const string VERSION = 'v4.3.4';

    /**
     * The base path for extensions.
     */
    protected string $extensionsPath = '';

    /**
     * The base path for themes.
     */
    protected string $themesPath = '';

    /**
     * The base path for temporary directory.
     */
    protected string $tempPath = '';

    /**
     * Indicates if the application has a valid database
     * connection and "settings" table.
     */
    protected bool $hasDatabase = false;

    protected array $coreMigrationPaths = [
        'igniter.system' => [__DIR__.'/../../../database/migrations/system'],
        'igniter.admin' => [__DIR__.'/../../../database/migrations/admin'],
        'igniter.main' => [__DIR__.'/../../../database/migrations/main'],
    ];

    protected array $migrationPaths = [];

    protected array $controllerPaths = [];

    protected array $ignoreMigrations = [];

    protected array $prunableModels = [];

    protected bool $disableThemeRoutes = false;

    protected bool $autoloadExtensions = true;

    protected array $publishesThemeFiles = [];

    protected bool $useMailerConfigFile = false;

    /**
     * Set the extensions path for the application.
     */
    public function useExtensionsPath(string $path): static
    {
        $this->extensionsPath = $path;

        return $this;
    }

    /**
     * Set the themes path for the application.
     */
    public function useThemesPath(string $path): static
    {
        $this->themesPath = $path;

        return $this;
    }

    /**
     * Set the temporary storage path for the application.
     */
    public function useTempPath(string $path): static
    {
        $this->tempPath = $path;

        return $this;
    }

    /**
     * Enable the use of the mailer config file.
     * This allows the application to use the mailer configuration
     * defined in the config/mail.php file instead of the default
     * mailer settings stored in the database.
     */
    public function useMailerConfigFile(): static
    {
        $this->useMailerConfigFile = true;

        return $this;
    }

    /**
     * Determine if the application is using the mailer config file.
     */
    public function usingMailerConfigFile(): bool
    {
        return $this->useMailerConfigFile;
    }

    /**
     * Determine if we are running in the admin area.
     */
    public function runningInAdmin(): bool
    {
        $requestPath = str_finish(normalize_uri(request()->path()), '/');
        $adminUri = str_finish(normalize_uri($this->adminUri()), '/');

        return starts_with($requestPath, $adminUri);
    }

    /**
     * Returns true if a database connection is present.
     */
    public function hasDatabase(bool $force = false): bool
    {
        try {
            if ($force || !$this->hasDatabase) {
                $schema = resolve('db.connection')->getSchemaBuilder();
                $this->hasDatabase = $schema->hasTable('settings') && $schema->hasTable('extension_settings');
            }
        } catch (Exception) {
            $this->hasDatabase = false;
        }

        return $this->hasDatabase;
    }

    /**
     * Get the path to the extension's directory.
     */
    public function extensionsPath(): string
    {
        return $this->extensionsPath ?: config('igniter-system.extensionsPath', base_path('extensions'));
    }

    /**
     * Get the path to the theme's directory.
     */
    public function themesPath(): string
    {
        return $this->themesPath ?: config('igniter-system.themesPath', base_path('themes'));
    }

    /**
     * Get the path to the storage/temp directory.
     */
    public function tempPath(): string
    {
        return $this->tempPath ?: config('igniter-system.tempPath', base_path('storage/temp'));
    }

    /**
     * Register database migration namespace.
     */
    public function loadMigrationsFrom(string $path, string $namespace): static
    {
        $this->migrationPaths[$namespace] = $path;

        return $this;
    }

    public function ignoreMigrations(string $namespace = '*'): static
    {
        $this->ignoreMigrations[] = $namespace;

        return $this;
    }

    /**
     * Get the database migration namespaces.
     */
    public function migrationPath(): array
    {
        return !in_array('*', $this->ignoreMigrations)
            ? array_except($this->migrationPaths, $this->ignoreMigrations)
            : [];
    }

    public function coreMigrationPath(): array
    {
        return !in_array('*', $this->ignoreMigrations)
            ? array_except($this->coreMigrationPaths, $this->ignoreMigrations)
            : [];
    }

    public function getSeedRecords(string $name): array
    {
        return json_decode(file_get_contents(__DIR__.'/../../../database/records/'.$name.'.json'), true);
    }

    /**
     * Get the path to the cached addons.php file.
     */
    public function getCachedAddonsPath(): string
    {
        return app()->bootstrapPath().'/cache/addons.php';
    }

    /**
     * Get the path to the cached classes.php file.
     */
    public function getCachedClassesPath(): string
    {
        return app()->bootstrapPath().'/cache/classes.php';
    }

    public function loadResourcesFrom(string $path, ?string $namespace = null): static
    {
        $callback = function(Filesystem $files) use ($path, $namespace) {
            $files->addPathSymbol($namespace, $path);
        };

        app()->afterResolving(Filesystem::class, $callback);

        if (app()->resolved(Filesystem::class)) {
            $callback(resolve(Filesystem::class));
        }

        return $this;
    }

    public function loadControllersFrom(string $path, string $namespace): static
    {
        $this->controllerPaths[$namespace] = $path;

        return $this;
    }

    public function loadViewsFrom(string|array $path, string $namespace): static
    {
        $callback = function(Factory $view) use ($path, $namespace) {
            $view->addNamespace($namespace, $path);
        };

        app()->afterResolving('view', $callback);

        if (app()->resolved('view')) {
            $callback(app('view'));
        }

        return $this;
    }

    public function controllerPath(): array
    {
        return $this->controllerPaths;
    }

    public function uri(): ?string
    {
        return config('igniter-routes.uri');
    }

    public function adminUri(): string
    {
        return config('igniter-routes.adminUri', '/admin');
    }

    public function isUser(Authenticatable $user): bool
    {
        return $this->isAdminUser($user) || $this->isCustomer($user);
    }

    public function isCustomer(?Authenticatable $user): bool
    {
        return $user instanceof Customer;
    }

    public function isAdminUser(?Authenticatable $user): bool
    {
        return $user instanceof User;
    }

    public function version(): string
    {
        return static::VERSION;
    }

    public function prunableModel(string|array $modelClass): static
    {
        if (is_string($modelClass)) {
            $modelClass = [$modelClass];
        }

        $this->prunableModels = array_merge($this->prunableModels, $modelClass);

        return $this;
    }

    public function prunableModels(): array
    {
        return $this->prunableModels;
    }

    public function disableThemeRoutes(?bool $value = null): bool|static
    {
        if (is_null($value)) {
            return $this->disableThemeRoutes;
        }

        $this->disableThemeRoutes = $value;

        return $this;
    }

    public function autoloadExtensions(?bool $value = null): bool|static
    {
        if (is_null($value)) {
            return $this->autoloadExtensions;
        }

        $this->autoloadExtensions = $value;

        return $this;
    }

    public function publishesThemeFiles(string|array $paths): static
    {
        foreach ((array)$paths as $path => $publishTo) {
            if (is_numeric($path)) {
                $path = $publishTo;
                $publishTo = null;
            }

            if (is_null($publishTo)) {
                $publishTo = $path;
            }

            $this->publishesThemeFiles[$path] = $publishTo;
        }

        return $this;
    }

    public function publishableThemeFiles(): array
    {
        return $this->publishesThemeFiles;
    }
}
