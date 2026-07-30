<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Source;

use Exception;
use Igniter\Flame\Filesystem\Filesystem;
use Igniter\Flame\Pagic\Exception\CreateDirectoryException;
use Igniter\Flame\Pagic\Exception\CreateFileException;
use Igniter\Flame\Pagic\Exception\DeleteFileException;
use Igniter\Flame\Pagic\Exception\FileExistsException;
use Igniter\Flame\Pagic\Processors\Processor;
use Override;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

/**
 * File based source.
 */
class FileSource extends AbstractSource implements SourceInterface
{
    /**
     * The filesystem instance.
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new source instance.
     * @param string $basePath
     */
    public function __construct(protected $basePath, ?Filesystem $files = null, public Finder $finder = new Finder)
    {
        $this->files = $files ?: resolve(Filesystem::class);
        $this->processor = new Processor;
    }

    /**
     * Returns a single template.
     */
    #[Override]
    public function select(string $dirName, string $fileName, string $extension): ?array
    {
        try {
            $path = $this->makeFilePath($dirName, $fileName, $extension);

            return [
                'fileName' => $fileName.'.'.$extension,
                'mTime' => $this->files->lastModified($path),
                'content' => $this->files->get($path),
            ];
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Returns all templates.
     */
    #[Override]
    public function selectAll($dirName, array $options = []): array
    {
        $columns = array_get($options, 'columns');  // Only return specific columns (fileName, mTime, content)
        $extensions = array_get($options, 'extensions');  // Match specified extensions
        $fileMatch = array_get($options, 'fileMatch');  // Match the file name using fnmatch()

        $result = [];
        $dirPath = $this->basePath.'/'.$dirName;

        if (!$this->files->isDirectory($dirPath)) {
            return $result;
        }

        $columns = $columns === ['*'] || !is_array($columns) ? null : array_flip($columns);

        $iterator = $this->finder->create()
            ->files()
            ->ignoreVCS(true)
            ->ignoreDotFiles(true)
            ->depth('<= 1');  // Support only a single level of subdirectories

        $iterator->filter(function(SplFileInfo $file) use ($extensions, $fileMatch) {
            // Filter by extension
            $fileExt = $file->getExtension();
            if (!is_null($extensions) && !in_array($fileExt, $extensions)) {
                return false;
            }

            // Filter by file name match
            if (!is_null($fileMatch) && !fnmatch($file->getBasename(), $fileMatch)) {
                return false;
            }
        });

        $files = iterator_to_array($iterator->in($dirPath), false);

        foreach ($files as $file) {
            $item = [];

            $path = $file->getPathName();

            $item['fileName'] = $file->getRelativePathName();

            if (!$columns || array_key_exists('mTime', $columns)) {
                $item['mTime'] = $this->files->lastModified($path);
            }

            if (!$columns || array_key_exists('content', $columns)) {
                $item['content'] = $this->files->get($path);
            }

            $result[] = $item;
        }

        return $result;
    }

    /**
     * Creates a new template.
     */
    #[Override]
    public function insert(string $dirName, string $fileName, string $extension, string $content): bool
    {
        $this->validateDirectoryForSave($dirName, $fileName, $extension);

        $path = $this->makeFilePath($dirName, $fileName, $extension);

        if ($this->files->isFile($path)) {
            throw (new FileExistsException)->setInvalidPath($path);
        }

        try {
            return (bool)$this->files->put($path, $content);
        } catch (Exception) {
            throw (new CreateFileException)->setInvalidPath($path);
        }
    }

    /**
     * Updates an existing template.
     */
    #[Override]
    public function update(string $dirName, string $fileName, string $extension, string $content, ?string $oldFileName = null, ?string $oldExtension = null): bool
    {
        $this->validateDirectoryForSave($dirName, $fileName, $extension);

        $path = $this->makeFilePath($dirName, $fileName, $extension);

        /*
         * The same file is safe to rename when the case is changed
         * eg: FooBar -> foobar
         */
        $iFileChanged = ($oldFileName !== null && strcasecmp($oldFileName, $fileName) !== 0) ||
            ($oldExtension !== null && strcasecmp($oldExtension, $extension) !== 0);

        if ($iFileChanged && $this->files->isFile($path)) {
            throw (new FileExistsException)->setInvalidPath($path);
        }

        /*
         * File to be renamed, as delete and recreate
         */
        $fileChanged = ($oldFileName !== null && strcmp($oldFileName, $fileName) !== 0) ||
            ($oldExtension !== null && strcmp($oldExtension, $extension) !== 0);

        if ($fileChanged) {
            $this->delete($dirName, $oldFileName, $oldExtension);
        }

        try {
            return (bool)$this->files->put($path, $content);
        } catch (Exception) {
            throw (new CreateFileException)->setInvalidPath($path);
        }
    }

    /**
     * Run a delete statement against the source.
     */
    #[Override]
    public function delete(string $dirName, string $fileName, string $extension): bool
    {
        $path = $this->makeFilePath($dirName, $fileName, $extension);

        try {
            return (bool)$this->files->delete($path);
        } catch (Exception) {
            throw (new DeleteFileException)->setInvalidPath($path);
        }
    }

    #[Override]
    public function path(string $path): ?string
    {
        return $this->basePath.'/'.$path;
    }

    /**
     * Run a delete statement against the source.
     */
    #[Override]
    public function lastModified(string $dirName, string $fileName, string $extension): ?int
    {
        try {
            $path = $this->makeFilePath($dirName, $fileName, $extension);

            return $this->files->lastModified($path);
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Ensure the requested file can be created in the requested directory.
     *
     * @param string $fileName
     * @return void
     */
    protected function validateDirectoryForSave(string $dirName, $fileName, string $extension)
    {
        $path = $this->makeFilePath($dirName, $fileName, $extension);
        $dirPath = $this->basePath.'/'.$dirName;

        // Create base directory
        if (
            (!$this->files->exists($dirPath) || !$this->files->isDirectory($dirPath)) &&
            !$this->files->makeDirectory($dirPath, 0777, true, true)
        ) {
            throw (new CreateDirectoryException)->setInvalidPath($dirPath);
        }

        // Create base file directory
        if (str_contains($fileName, '/')) {
            $fileDirPath = $this->files->dirname($path);

            if (
                !$this->files->isDirectory($fileDirPath) &&
                !$this->files->makeDirectory($fileDirPath, 0777, true, true)
            ) {
                throw (new CreateDirectoryException)->setInvalidPath($fileDirPath);
            }
        }
    }

    /**
     * Helper to make file path.
     */
    protected function makeFilePath(string $dirName, string $fileName, string $extension): string
    {
        return $this->basePath.'/'.$dirName.'/'.$fileName.'.'.$extension;
    }

    /**
     * Generate a cache key unique to this source.
     */
    #[Override]
    public function makeCacheKey(string $name = ''): int
    {
        return parent::makeCacheKey($this->basePath.$name);
    }

    /**
     * Returns the base path for this source.
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Generate a paths cache key unique to this source
     */
    public function getPathsCacheKey(): string
    {
        return 'pagic-source-file-'.$this->basePath;
    }
}
