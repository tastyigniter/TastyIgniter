<?php

declare(strict_types=1);

namespace Igniter\Flame\Support;

use Exception;
use Igniter\Flame\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

/**
 * Class loader
 *
 * A simple autoloader used by Winter, it expects the folder names
 * to be lower case and the file name to be capitalized as per the class name.
 */
class ClassLoader
{
    /**
     * The loaded manifest array.
     * @var array
     */
    public $manifest;

    /**
     * The registered directories.
     * @var array
     */
    protected $directories = [];

    /**
     * Indicates if a loader has been registered.
     * @var bool
     */
    protected $registered = false;

    /**
     * Determine if the manifest needs to be written.
     * @var bool
     */
    protected $manifestIsDirty = false;

    /**
     * Class alias array.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Namespace alias array.
     *
     * @var array
     */
    protected $namespaceAliases = [];

    /**
     * Aliases that have been explicitly loaded.
     *
     * @var array
     */
    protected $loadedAliases = [];

    /**
     * Reversed classes to ignore for alias checks.
     *
     * @var array
     */
    protected $reversedClasses = [];

    public function __construct(public Filesystem $files, public string $basePath, public ?string $manifestPath) {}

    /**
     * Register loader with SPL autoloader stack.
     */
    public function register(): void
    {
        if ($this->registered) {
            return;
        }

        $this->ensureManifestIsLoaded();

        $this->registered = spl_autoload_register($this->load(...));
    }

    /**
     * De-register the given class loader on the auto-loader stack.
     */
    public function unregister(): void
    {
        if (!$this->registered) {
            return;
        }

        spl_autoload_unregister($this->load(...));
        $this->registered = false;
    }

    /**
     * Build the manifest and write it to disk.
     */
    public function build(): void
    {
        if (!$this->manifestIsDirty) {
            return;
        }

        $this->write($this->manifest);
    }

    /**
     * Load the given class file.
     *
     * @param string $class
     */
    public function load($class): ?bool
    {
        $class = static::normalizeClass($class);

        // If the class is already aliased, skip loading.
        if (in_array($class, $this->loadedAliases) || in_array($class, $this->reversedClasses)) {
            return true;
        }

        if (
            isset($this->manifest[$class]) &&
            $this->isRealFilePath($path = $this->manifest[$class])
        ) {
            require_once $this->basePath.DIRECTORY_SEPARATOR.$path;

            if (!is_null($reverse = $this->getReverseAlias($class)) && (!class_exists($reverse, false) && !in_array($reverse, $this->loadedAliases))) {
                class_alias($class, $reverse);
                $this->reversedClasses[] = $reverse;
            }

            return true;
        }

        [$lowerClass, $upperClass, $lowerClassStudlyFile, $upperClassStudlyFile] = static::getPathsForClass($class);

        foreach ($this->directories as $directory) {
            $paths = [
                $directory.DIRECTORY_SEPARATOR.$upperClass,
                $directory.DIRECTORY_SEPARATOR.$lowerClass,
                $directory.DIRECTORY_SEPARATOR.$lowerClassStudlyFile,
                $directory.DIRECTORY_SEPARATOR.$upperClassStudlyFile,
            ];

            foreach ($paths as $path) {
                if ($this->isRealFilePath($path)) {
                    $this->includeClass($class, $path);

                    if (!is_null($reverse = $this->getReverseAlias($class)) && (!class_exists($reverse, false) && !in_array($reverse, $this->loadedAliases))) {
                        class_alias($class, $reverse);
                        $this->reversedClasses[] = $reverse;
                    }

                    return true;
                }
            }
        }

        if (!in_array($class, $this->reversedClasses) && !is_null($alias = $this->getAlias($class))) {
            $this->loadedAliases[] = $class;
            class_alias($alias, $class);

            return true;
        }

        return null;
    }

    /**
     * Gets all the directories registered with the loader.
     *
     * @return array
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * Add directories to the class loader.
     *
     * @param string|array $directories
     */
    public function addDirectories($directories): void
    {
        $this->directories = array_merge($this->directories, (array)$directories);

        $this->directories = array_unique($this->directories);
    }

    /**
     * Remove directories from the class loader.
     *
     * @param string|array $directories
     */
    public function removeDirectories($directories = null): void
    {
        if (is_null($directories)) {
            $this->directories = [];
        } else {
            $directories = (array)$directories;

            $this->directories = array_filter($this->directories, fn($directory): bool => !in_array($directory, $directories));
        }
    }

    /**
     * Adds alias to the class loader.
     *
     * Aliases are first-come, first-served. If a real class already exists with the same name as an alias, the real
     * class is used over the alias.
     */
    public function addAliases(array $aliases): void
    {
        foreach ($aliases as $original => $alias) {
            if (!array_key_exists($alias, $this->aliases)) {
                $this->aliases[$alias] = $original;
            }
        }
    }

    /**
     * Adds namespace aliases to the class loader.
     *
     * Similar to the "addAliases" method, but applies across an entire namespace.
     *
     * Aliases are first-come, first-served. If a real class already exists with the same name as an alias, the real
     * class is used over the alias.
     */
    public function addNamespaceAliases(array $namespaceAliases): void
    {
        foreach ($namespaceAliases as $original => $alias) {
            if (!array_key_exists($alias, $this->namespaceAliases)) {
                $alias = ltrim((string)$alias, '\\');
                $original = ltrim((string)$original, '\\');
                $this->namespaceAliases[$alias] = $original;
            }
        }
    }

    /**
     * Gets an alias for a class, if available.
     *
     * @param string $class
     * @return string|null
     */
    public function getAlias($class)
    {
        if (count($this->namespaceAliases)) {
            foreach ($this->namespaceAliases as $alias => $original) {
                if (starts_with($class, $alias)) {
                    return str_replace($alias, $original, $class);
                }
            }
        }

        return $this->aliases[$class] ?? null;
    }

    /**
     * Gets aliases registered for a namespace, if available.
     *
     * @param string $namespace
     */
    public function getNamespaceAliases($namespace): array
    {
        $aliases = [];
        foreach ($this->namespaceAliases as $alias => $original) {
            if ($namespace === $original) {
                $aliases[] = $alias;
            }
        }

        return $aliases;
    }

    /**
     * Gets a reverse alias for a class, if available.
     *
     * @param string $class
     * @return string|null
     */
    public function getReverseAlias($class): string|array|int|null
    {
        if (count($this->namespaceAliases)) {
            foreach ($this->namespaceAliases as $alias => $original) {
                if (starts_with($class, $original)) {
                    return str_replace($original, $alias, $class);
                }
            }
        }

        $aliasKey = array_search($class, $this->aliases, true);

        return ($aliasKey !== false) ? $aliasKey : null;
    }

    /**
     * Normalise the class name.
     *
     * @param string $class
     */
    protected static function normalizeClass($class): string
    {
        // Strip first slash
        if (str_starts_with($class, '\\')) {
            $class = substr($class, 1);
        }

        return implode('\\', array_map(fn($part) => $part, explode('\\', $class)));
    }

    /**
     * Get the possible paths for a class.
     *
     * @param string $class
     */
    protected static function getPathsForClass($class): array
    {
        // Lowercase folders
        $parts = explode('\\', $class);
        $file = array_pop($parts);
        $namespace = implode('\\', $parts);
        $directory = str_replace(['\\', '_'], DIRECTORY_SEPARATOR, $namespace);

        // Provide both alternatives
        $lowerClass = strtolower($directory).DIRECTORY_SEPARATOR.$file.'.php';
        $upperClass = $directory.DIRECTORY_SEPARATOR.$file.'.php';

        $lowerClassStudlyFile = strtolower($directory).DIRECTORY_SEPARATOR.Str::studly($file).'.php';
        $upperClassStudlyFile = $directory.DIRECTORY_SEPARATOR.Str::studly($file).'.php';

        return [$lowerClass, $upperClass, $lowerClassStudlyFile, $upperClassStudlyFile];
    }

    /**
     * Determine if a relative path to a file exists and is real
     */
    protected function isRealFilePath(string $path): bool
    {
        $filename = realpath($this->basePath.DIRECTORY_SEPARATOR.$path);

        return $filename && is_file($filename);
    }

    /**
     * Includes a class and adds to the manifest
     *
     * @param string $class
     * @return void
     */
    protected function includeClass($class, string $path)
    {
        require_once $this->basePath.DIRECTORY_SEPARATOR.$path;

        $this->manifest[$class] = $path;

        $this->manifestIsDirty = true;
    }

    /**
     * Ensure the manifest has been loaded into memory.
     *
     * @return void
     */
    protected function ensureManifestIsLoaded()
    {
        if (!is_null($this->manifest)) {
            return;
        }

        if ($this->files->exists($this->manifestPath)) {
            try {
                $this->manifest = $this->files->getRequire($this->manifestPath);

                if (!is_array($this->manifest)) {
                    $this->manifest = [];
                }
            } catch (Throwable) {
                $this->manifest = [];
            }
        } else {
            $this->manifest = [];
        }
    }

    /**
     * Write the manifest array to filesystem.
     *
     * @return void
     * @throws Exception
     */
    protected function write(array $manifest)
    {
        if (!is_writable($path = $this->files->dirname($this->manifestPath))) {
            throw new RuntimeException('The '.$path.' directory must be present and writable.');
        }

        $this->files->put(
            $this->manifestPath, '<?php return '.var_export($manifest, true).';',
        );
    }
}
