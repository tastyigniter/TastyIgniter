<?php

declare(strict_types=1);

namespace Igniter\Flame\Filesystem;

use FilesystemIterator;
use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Str;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Override;
use ReflectionClass;

/**
 * File helper
 *
 * Adapted from october\rain\filesystem\Filesystem
 */
class Filesystem extends IlluminateFilesystem
{
    /** Hint path delimiter value. */
    public const HINT_PATH_DELIMITER = '::';

    /** Default file permission mask as a string ("777"). */
    public ?string $filePermissions = null;

    /** Default folder permission mask as a string ("777"). */
    public ?string $folderPermissions = null;

    /** Known path symbols and their prefixes. */
    public array $pathSymbols = [];

    /** Symlinks within base folder */
    protected ?array $symlinks = null;

    /**
     * Determine if the given path contains no files.
     */
    public function isDirectoryEmpty(string $directory): bool
    {
        if (!is_readable($directory)) {
            return true;
        }

        $handle = opendir($directory);
        while (false !== ($entry = readdir($handle))) {
            if ($entry !== '.' && $entry !== '..') {
                closedir($handle);

                return false;
            }
        }

        closedir($handle);

        return true;
    }

    /**
     * Converts a file size in bytes to human readable format.
     */
    public function sizeToString(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2).' GB';
        }

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        }

        if ($bytes > 1) {
            return $bytes.' bytes';
        }

        if ($bytes === 1) {
            return $bytes.' byte';
        }

        return '0 bytes';
    }

    /**
     * Returns a public file path from an absolute one
     * eg: /home/mysite/public_html/welcome -> /welcome
     */
    public function localToPublic(string $path): ?string
    {
        $result = null;
        $publicPath = public_path();
        if (str_starts_with($path, $publicPath)) {
            $result = str_replace('\\', '/', substr($path, strlen($publicPath)));
        }

        return $result;
    }

    /**
     * Returns true if the specified path is within the path of the application
     * @param string $path The path to
     * @param bool $realpath Default true, uses realpath() to resolve the provided path before checking location. Set to false if you need to check if a potentially non-existent path would be within the application path
     */
    public function isLocalPath(string $path, bool $realpath = true): bool
    {
        $base = base_path();

        if ($realpath) {
            $path = realpath($path);
        }

        return $path !== false && str_starts_with($path, $base);
    }

    /**
     * Returns true if the provided disk is using the "local" driver
     */
    public function isLocalDisk(FilesystemAdapter $disk): bool
    {
        return $disk->getAdapter() instanceof LocalFilesystemAdapter;
    }

    /**
     * Finds the path to a class
     */
    public function fromClass(string|object $className): string
    {
        $reflector = new ReflectionClass($className);

        return $reflector->getFileName();
    }

    /**
     * Determine if a file exists with case insensitivity
     * supported for the file only.
     */
    public function existsInsensitive(string $path): string|false
    {
        if ($this->exists($path)) {
            return $path;
        }

        $directoryName = dirname($path);
        $pathLower = strtolower($path);

        if (!$files = $this->glob($directoryName.'/*', GLOB_NOSORT)) {
            return false;
        }

        foreach ($files as $file) {
            if (strtolower((string)$file) === $pathLower) {
                return $file;
            }
        }

        return false;
    }

    /**
     * Normalizes the directory separator, often used by Win systems.
     */
    public function normalizePath(string $path): string
    {
        return str_replace('\\', '/', $path);
    }

    /**
     * Converts a path using path symbol. Returns the original path if
     * no symbol is used and no default is specified.
     */
    public function symbolizePath(string $path, ?bool $default = false, bool $findExists = true): string|bool|null
    {
        if (!$symbol = $this->isPathSymbol($path)) {
            return $default === false ? $path : $default;
        }

        $_path = (string)Str::of(Str::after($path, $symbol))->after(static::HINT_PATH_DELIMITER);
        if ($_path && !Str::startsWith($_path, '/')) {
            $_path = '/'.$_path;
        }

        if (!$findExists) {
            return current($this->pathSymbols[$symbol]).$_path;
        }

        foreach ($this->pathSymbols[$symbol] as $pathSymbol) {
            if ($this->exists($pathSymbol.$_path)) {
                return $pathSymbol.$_path;
            }
        }

        return $path;
    }

    /**
     * Returns true if the path uses a symbol.
     */
    public function isPathSymbol(string $path): string|false
    {
        $symbol = Str::contains($path, static::HINT_PATH_DELIMITER)
            ? Str::before($path, static::HINT_PATH_DELIMITER)
            : substr($path, 0, 1);

        if (isset($this->pathSymbols[$symbol])) {
            return $symbol;
        }

        return false;
    }

    public function addPathSymbol(string $symbol, string $path): void
    {
        if (!array_key_exists($symbol, $this->pathSymbols) || !is_array($this->pathSymbols[$symbol])) {
            $this->pathSymbols[$symbol] = [];
        }

        array_unshift($this->pathSymbols[$symbol], $path);
    }

    /**
     * Write the contents of a file.
     * @param string $path
     * @param string $contents
     * @return int
     */
    #[Override]
    public function put($path, $contents, $lock = false)
    {
        $result = parent::put($path, $contents, $lock);
        $this->chmod($path);

        return $result;
    }

    /**
     * Copy a file to a new location.
     * @param string $path
     * @param string $target
     * @return bool
     */
    #[Override]
    public function copy($path, $target)
    {
        $result = parent::copy($path, $target);
        $this->chmod($target);

        return $result;
    }

    /**
     * Create a directory.
     * @param string $path
     * @param ?int $mode
     * @param bool $recursive
     * @param bool $force
     * @return bool
     */
    #[Override]
    public function makeDirectory($path, $mode = 0755, $recursive = false, $force = false)
    {
        if ($mask = $this->getFolderPermissions()) {
            $mode = $mask;
        }

        // Find the green leaves
        $chmodPath = $path;
        if ($recursive && $mask) {
            while (true) {
                $basePath = $this->dirname($chmodPath);
                if ($chmodPath == $basePath) {
                    break;
                }

                if ($this->isDirectory($basePath)) {
                    break;
                }

                $chmodPath = $basePath;
            }
        }

        // Make the directory
        $result = parent::makeDirectory($path, $mode, $recursive, $force);

        // Apply the permissions
        if ($mask) {
            $this->chmod($chmodPath, $mask);

            if ($recursive) {
                $this->chmodRecursive($chmodPath, null, $mask);
            }
        }

        return $result;
    }

    /**
     * Modify file/folder permissions
     */
    #[Override]
    public function chmod($path, mixed $mode = null): bool
    {
        if (!$mode) {
            $mode = $this->isDirectory($path)
                ? $this->getFolderPermissions()
                : $this->getFilePermissions();
        }

        if (!$mode) {
            return false;
        }

        return @chmod($path, $mode);
    }

    /**
     * Modify file/folder permissions recursively
     */
    public function chmodRecursive(string $path, null|int|string $fileMask = null, null|int|float $directoryMask = null): ?bool
    {
        if (!$fileMask) {
            $fileMask = $this->getFilePermissions();
        }

        if (!$directoryMask) {
            $directoryMask = $this->getFolderPermissions() ?: $fileMask;
        }

        if (!$fileMask) {
            return false;
        }

        if (!$this->isDirectory($path)) {
            $this->chmod($path, $fileMask);

            return false;
        }

        $items = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);
        foreach ($items as $item) {
            if ($item->isDir()) {
                $_path = $item->getPathname();
                $this->chmod($_path, $directoryMask);
                $this->chmodRecursive($_path, $fileMask, $directoryMask);
            } else {
                $this->chmod($item->getPathname(), $fileMask);
            }
        }

        return null;
    }

    /**
     * Returns the default file permission mask to use.
     */
    public function getFilePermissions(): null|float|int
    {
        return $this->filePermissions
            ? octdec($this->filePermissions)
            : null;
    }

    /**
     * Returns the default folder permission mask to use.
     */
    public function getFolderPermissions(): null|float|int
    {
        return $this->folderPermissions
            ? octdec($this->folderPermissions)
            : null;
    }

    /**
     * Match filename against a pattern.
     */
    public function fileNameMatch(string $fileName, string $pattern): bool
    {
        if ($pattern === $fileName) {
            return true;
        }

        $regex = strtr(preg_quote($pattern, '#'), ['\*' => '.*', '\?' => '.']);

        return (bool)preg_match('#^'.$regex.'$#i', $fileName);
    }
}
