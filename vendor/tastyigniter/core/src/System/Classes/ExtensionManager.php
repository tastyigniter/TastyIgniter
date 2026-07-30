<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Facades\Igniter\System\Helpers\SystemHelper;
use Igniter\Flame\Composer\Manager;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\System\Models\Extension;
use LogicException;
use ZipArchive;

/**
 * Modules class for TastyIgniter.
 * Provides utility functions for working with modules.
 */
class ExtensionManager
{
    /** Used for storing extension information objects. */
    protected array $extensions = [];

    protected array $disabledExtensions = [];

    protected array $coreExtensions = [];

    /** Cache of registration method results. */
    protected array $registrationMethodCache = [];

    /** Array of extensions and their directory paths. */
    protected array $paths = [];

    protected array $directories = [];

    public function __construct(protected PackageManifest $packageManifest, protected Manager $composerManager)
    {
        $this->disabledExtensions = $this->packageManifest->disabledAddons();
        $this->coreExtensions = $this->packageManifest->coreAddons();
        $this->loadExtensions();
    }

    public function addDirectory(string $directory): void
    {
        $this->directories[] = $directory;
    }

    /**
     * Return the path to the extension and its specified folder.
     */
    public function path(string $extension, ?string $folder = null): string
    {
        $path = array_get($this->paths(), $extension);

        if (!is_null($folder)) {
            return $path.'/'.$folder;
        }

        return $path.'/';
    }

    /**
     * Return an associative array of files within one or more extensions.
     * @codeCoverageIgnore
     */
    public function files(?string $extensionName = null, ?string $subFolder = null): bool|array
    {
        $files = [];
        traceLog('Deprecated method, remove before v5');

        return $files;
    }

    /**
     * Search a extension folder for files.
     * @codeCoverageIgnore
     */
    public function filesPath(string $extensionName, ?string $path = null): array
    {
        traceLog('Deprecated method, remove before v5');

        return [];
    }

    /**
     * Returns an array of the folders in which extensions may be stored.
     */
    public function folders(): array
    {
        $paths = [];

        $directories = $this->directories;
        if (File::isDirectory($extensionsPath = Igniter::extensionsPath())) {
            array_unshift($directories, $extensionsPath);
        }

        foreach ($directories as $directory) {
            foreach (File::glob($directory.'/*/*/{extension,composer}.json', GLOB_BRACE) as $path) {
                $paths[] = dirname((string)$path);
            }
        }

        return $paths;
    }

    /**
     * Returns a list of all extensions in the system.
     */
    public function listExtensions(): array
    {
        return array_keys($this->paths());
    }

    /**
     * Create a Directory Map of all extensions
     */
    public function paths(): array
    {
        return $this->paths;
    }

    /**
     * Finds all available extensions and loads them in to the $extensions array.
     */
    public function loadExtensions(): array
    {
        $this->extensions = [];

        foreach ($this->folders() as $path) {
            $this->loadExtension($path);
        }

        $this->packageManifest->manifest = null; // @phpstan-ignore assign.propertyType
        foreach ($this->packageManifest->extensions() as $config) {
            $path = $this->packageManifest->getPackagePath(array_get($config, 'installPath'));
            if (File::isDirectory($path)) {
                $this->loadExtension($path);
            }
        }

        return $this->extensions;
    }

    /**
     * Loads a single extension in to the manager.
     * @param string $path Eg: base_path().'/extensions/vendor/extension';
     * @throws SystemException
     */
    public function loadExtension(string $path): BaseExtension
    {
        $config = SystemHelper::extensionConfigFromFile($path);

        throw_unless($namespace = array_get($config, 'namespace'),
            new SystemException('Extension namespace not found in '.$path),
        );

        $identifier = array_get($config, 'code', $this->getIdentifier($namespace));

        throw_unless(
            $this->checkName($identifier),
            new SystemException('Extension code can only contain alphabets: '.$identifier),
        );

        if (isset($this->extensions[$identifier])) {
            return $this->extensions[$identifier];
        }

        $loader = $this->composerManager->getLoader();
        if (File::isDirectory($path.'/src') && $loader && !array_key_exists($namespace, $loader->getPrefixesPsr4() ?? [])) {
            $loader->setPsr4($namespace, $path.'/src');
        }

        $class = $namespace.'Extension';
        $extension = $this->resolveExtension($identifier, $path, $class);

        $extension->extensionMeta($config);

        // Check for disabled extensions
        if ($this->isDisabled($identifier)) {
            $extension->disabled = true;
        }

        $this->extensions[$identifier] = $extension;
        $this->paths[$identifier] = $path;

        return $extension;
    }

    public function resolveExtension(string $identifier, ?string $path, ?string $class)
    {
        throw_if(
            !$path || !File::isDirectory($path) || $path === base_path(),
            SystemException::class, 'Extension directory not found: '.$path,
        );

        if (!$class || !class_exists($class)) {
            throw new LogicException(sprintf("Missing Extension class '%s' in '%s', create the Extension class to override extensionMeta() method.", $class, $identifier));
        }

        if (!is_subclass_of($class, BaseExtension::class)) {
            throw new LogicException(sprintf("Extension class '%s' must extend '", $class).BaseExtension::class."'.");
        }

        return app()->resolveProvider($class);
    }

    /**
     * Returns an array with all registered extensions
     * The index is the extension name, the value is the extension object.
     */
    public function getExtensions(): array
    {
        $extensions = [];
        foreach ($this->extensions as $code => $extension) {
            if (!$extension->disabled) {
                $extensions[$code] = $extension;
            }
        }

        return $extensions;
    }

    /**
     * Returns a extension registration class based on its name.
     */
    public function findExtension(string $code): ?BaseExtension
    {
        if (!$this->hasExtension($code)) {
            return null;
        }

        return $this->extensions[$code];
    }

    /**
     * Checks to see if an extension name is well formed.
     */
    public function checkName(string $code): ?string
    {
        return (str_starts_with($code, '_') || preg_match('/\s/', $code)) ? null : $code;
    }

    public function getIdentifier(string $namespace): string
    {
        $namespace = trim($namespace, '\\');

        return strtolower(str_replace('\\', '.', $namespace));
    }

    public function getNamePath(string $code): string
    {
        return str_replace('.', '/', $code);
    }

    public function getExtensionPath(string $code, string $path = ''): string
    {
        return ($this->paths[$code] ?? null).$path;
    }

    /**
     * Checks to see if an extension has been registered.
     */
    public function hasExtension(string $code): bool
    {
        return isset($this->extensions[$code]);
    }

    public function hasVendor(string $path): bool
    {
        return array_key_exists($path, array_undot($this->paths()));
    }

    /**
     * Returns a flat array of extensions namespaces and their paths
     */
    public function namespaces(): array
    {
        $classNames = [];

        foreach ($this->paths as $namespace => $path) {
            $namespace = str_replace('.', '\\', $namespace);
            $classNames[$namespace] = $path;
        }

        return $classNames;
    }

    /**
     * Determines if an extension is disabled by looking at the installed extension config.
     */
    public function isDisabled(string $code): bool
    {
        return !$this->checkName($code) || array_get($this->disabledExtensions, $code, !Igniter::autoloadExtensions());
    }

    public function isRequired(string $code): bool
    {
        return in_array($code, array_column($this->coreExtensions, 'code'));
    }

    /**
     * Spins over every extension object and collects the results of a method call.
     */
    public function getRegistrationMethodValues(string $methodName): array
    {
        if (isset($this->registrationMethodCache[$methodName])) {
            return $this->registrationMethodCache[$methodName];
        }

        $results = [];
        $extensions = $this->getExtensions();
        foreach ($extensions as $id => $extension) {
            if (!is_callable([$extension, $methodName])) {
                continue;
            }

            $results[$id] = $extension->{$methodName}();
        }

        return $this->registrationMethodCache[$methodName] = $results;
    }

    public function updateInstalledExtensions(string $code, bool $enable = true): bool
    {
        $code = $this->getIdentifier($code);

        if ($enable) {
            array_pull($this->disabledExtensions, $code);
        } else {
            $this->disabledExtensions[$code] = true;
        }

        $this->packageManifest->writeDisabled($this->disabledExtensions);

        if (!is_null($extension = $this->findExtension($code))) {
            $extension->disabled = $enable === false;
        }

        return true;
    }

    /**
     * Delete extension the filesystem
     */
    public function removeExtension(?string $extCode = null): bool
    {
        if (empty($extensionPath = $this->getExtensionPath($extCode))) {
            return false;
        }

        // Delete the specified extension folder.
        if (File::isDirectory($extensionPath)) {
            File::deleteDirectory($extensionPath);
        }

        $vendorPath = dirname($extensionPath);

        // Delete the specified extension vendor folder if it has no extension.
        if (File::isDirectory($vendorPath) && !count(File::directories($vendorPath))) {
            File::deleteDirectory($vendorPath);
        }

        return true;
    }

    /**
     * Extract uploaded extension zip folder
     */
    public function extractExtension(string $zipPath): string
    {
        $extensionCode = null;
        $extractTo = Igniter::extensionsPath();

        $zip = resolve(ZipArchive::class);
        if ($zip->open($zipPath) === true) {
            $extensionDir = $zip->getNameIndex(0);

            if (!$this->checkName($extensionDir)) {
                throw new SystemException('Extension name can not have spaces.');
            }

            if ($zip->locateName($extensionDir.'Extension.php') === false) {
                throw new SystemException('Extension registration class was not found.');
            }

            throw_if(
                File::exists($configFile = $extensionDir.'extension.json'),
                new SystemException('extension.json files are no longer supported, please convert to composer.json: '.$configFile),
            );

            $meta = @json_decode($zip->getFromName($extensionDir.'composer.json'));
            if (!$meta || !strlen((string)$meta->code)) {
                throw new SystemException(lang('igniter::system.extensions.error_config_no_found'));
            }

            $extensionCode = $meta->code;
            $extractToPath = $extractTo.'/'.$this->getNamePath($meta->code);
            $zip->extractTo($extractToPath);
            $zip->close();
        }

        return $extensionCode;
    }

    /**
     * Install a new or existing extension by code
     */
    public function installExtension(string $code, ?string $version = null): bool
    {
        /** @var Extension $model */
        $model = Extension::firstOrNew(['name' => $code]);
        if ($model->applyExtensionClass() && $extension = $this->findExtension($model->name)) {
            // Register and boot the extension to make
            // its services available before migrating
            $extension->disabled = false;
            app()->register($extension);

            // set extension migration to the latest version
            resolve(UpdateManager::class)->migrateExtension($model->name);
        }

        $model->version = $version ?? $model->version;
        $model->save();

        $this->updateInstalledExtensions($model->name);

        return true;
    }

    /**
     * Uninstall a new or existing extension by code
     */
    public function uninstallExtension(string $code, bool $purgeData = false): bool
    {
        if ($purgeData) {
            resolve(UpdateManager::class)->purgeExtension($code);
        }

        $this->updateInstalledExtensions($code, false);

        return true;
    }

    /**
     * Delete a single extension by code
     */
    public function deleteExtension(string $code, bool $purgeData = true): void
    {
        if ($purgeData) {
            Extension::where('name', $code)->delete();

            resolve(UpdateManager::class)->purgeExtension($code);
        }

        // Remove extensions files from filesystem
        $composerManager = resolve(Manager::class);
        if ($packageName = $composerManager->getPackageName($code)) {
            $composerManager->uninstall([$packageName]);
        } else {
            $this->removeExtension($code);
        }
    }
}
