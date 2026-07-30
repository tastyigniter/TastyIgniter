<?php

declare(strict_types=1);

namespace Igniter\Flame\Support\Facades;

use Closure;
use Igniter\Flame\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Facade as IlluminateFacade;
use Illuminate\Support\LazyCollection;
use Override;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @method static bool isDirectoryEmpty(string $directory)
 * @method static string sizeToString(int $bytes)
 * @method static string|null localToPublic(string $path)
 * @method static bool isLocalPath(string $path, bool $realpath = true)
 * @method static bool isLocalDisk(FilesystemAdapter $disk)
 * @method static string fromClass(object|string $className)
 * @method static string|false existsInsensitive(string $path)
 * @method static string normalizePath(string $path)
 * @method static string|bool|null symbolizePath(string $path, bool|null $default = false, bool $findExists = true)
 * @method static string|false isPathSymbol(string $path)
 * @method static void addPathSymbol(string $symbol, string $path)
 * @method static int put(string $path, string $contents, bool $lock = false)
 * @method static bool copy(string $path, string $target)
 * @method static bool makeDirectory(string $path, null|int $mode = 511, bool $recursive = false, bool $force = false)
 * @method static bool chmod(string $path, int|null $mode = null)
 * @method static void chmodRecursive(string $path, string|null $fileMask = null, int|float|null $directoryMask = null)
 * @method static int|float|null getFilePermissions()
 * @method static int|float|null getFolderPermissions()
 * @method static bool fileNameMatch(string $fileName, string $pattern)
 * @method static bool exists(string $path)
 * @method static bool missing(string $path)
 * @method static string get(string $path, bool $lock = false)
 * @method static array json(string $path, int $flags = 0, bool $lock = false)
 * @method static string sharedGet(string $path)
 * @method static mixed getRequire(string $path, array $data = [])
 * @method static mixed requireOnce(string $path, array $data = [])
 * @method static LazyCollection lines(string $path)
 * @method static string|false hash(string $path, string $algorithm = 'md5')
 * @method static void replace(string $path, string $content, int|null $mode = null)
 * @method static void replaceInFile(array|string $search, array|string $replace, string $path)
 * @method static int prepend(string $path, string $data)
 * @method static int append(string $path, string $data, bool $lock = false)
 * @method static bool delete(string|array $paths)
 * @method static bool move(string $path, string $target)
 * @method static bool|null link(string $target, string $link)
 * @method static void relativeLink(string $target, string $link)
 * @method static string name(string $path)
 * @method static string basename(string $path)
 * @method static string dirname(string $path)
 * @method static string extension(string $path)
 * @method static string|null guessExtension(string $path)
 * @method static string type(string $path)
 * @method static string|false mimeType(string $path)
 * @method static int size(string $path)
 * @method static int lastModified(string $path)
 * @method static bool isDirectory(string $directory)
 * @method static bool isEmptyDirectory(string $directory, bool $ignoreDotFiles = false)
 * @method static bool isReadable(string $path)
 * @method static bool isWritable(string $path)
 * @method static bool hasSameHash(string $firstFile, string $secondFile)
 * @method static bool isFile(string $file)
 * @method static array glob(string $pattern, int $flags = 0)
 * @method static SplFileInfo[] files(string $directory, bool $hidden = false)
 * @method static SplFileInfo[] allFiles(string $directory, bool $hidden = false)
 * @method static array directories(string $directory)
 * @method static void ensureDirectoryExists(string $path, int $mode = 0755, bool $recursive = true)
 * @method static bool moveDirectory(string $from, string $to, bool $overwrite = false)
 * @method static bool copyDirectory(string $directory, string $destination, int|null $options = null)
 * @method static bool deleteDirectory(string $directory, bool $preserve = false)
 * @method static bool deleteDirectories(string $directory)
 * @method static bool cleanDirectory(string $directory)
 * @method static Filesystem|mixed when(Closure | mixed | null $value = null, callable | null $callback = null, callable | null $default = null)
 * @method static Filesystem|mixed unless(Closure | mixed | null $value = null, callable | null $callback = null, callable | null $default = null)
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 *
 * @see Filesystem
 */
class File extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @see Filesystem
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return Filesystem::class;
    }
}
