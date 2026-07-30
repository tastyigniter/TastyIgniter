<?php

declare(strict_types=1);

namespace Igniter\Flame\Support\Facades;

use Igniter\Flame\Filesystem\Filesystem;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @method static \Igniter\Flame\Support\Igniter useExtensionsPath(string $path)
 * @method static \Igniter\Flame\Support\Igniter useThemesPath(string $path)
 * @method static \Igniter\Flame\Support\Igniter useTempPath(string $path)
 * @method static bool runningInAdmin()
 * @method static bool hasDatabase(bool $force = false)
 * @method static string extensionsPath()
 * @method static string themesPath()
 * @method static string tempPath()
 * @method static \Igniter\Flame\Support\Igniter loadMigrationsFrom(string $path, string $namespace)
 * @method static \Igniter\Flame\Support\Igniter ignoreMigrations(string $namespace = '*')
 * @method static array migrationPath()
 * @method static array coreMigrationPath()
 * @method static array getSeedRecords(string $name)
 * @method static string getCachedAddonsPath()
 * @method static string getCachedClassesPath()
 * @method static \Igniter\Flame\Support\Igniter loadResourcesFrom(string $path, string|null $namespace = null)
 * @method static \Igniter\Flame\Support\Igniter loadControllersFrom(string $path, string $namespace)
 * @method static \Igniter\Flame\Support\Igniter loadViewsFrom(array|string $path, string $namespace)
 * @method static array controllerPath()
 * @method static string|null uri()
 * @method static string adminUri()
 * @method static bool isUser(Authenticatable $user)
 * @method static bool isCustomer(?Authenticatable $user)
 * @method static bool isAdminUser(?Authenticatable $user)
 * @method static string version()
 * @method static \Igniter\Flame\Support\Igniter prunableModel(array|string $modelClass)
 * @method static array prunableModels()
 * @method static \Igniter\Flame\Support\Igniter|bool disableThemeRoutes(bool|null $value = null)
 * @method static \Igniter\Flame\Support\Igniter|bool autoloadExtensions(bool|null $value = null)
 * @method static \Igniter\Flame\Support\Igniter publishesThemeFiles(array|string $paths)
 * @method static array publishableThemeFiles()
 *
 * @see \Igniter\Flame\Support\Igniter
 */
class Igniter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @see Filesystem
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return \Igniter\Flame\Support\Igniter::class;
    }
}
