<?php

namespace Main\Classes;

use Exception;
use Igniter\Flame\Pagic\Processors\Processor;
use Igniter\Flame\Pagic\Source\AbstractSource;
use Igniter\Flame\Pagic\Source\SourceInterface;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Finder\Finder;

class ChainFileSource extends AbstractSource implements SourceInterface
{
    /**
     * @var array The available source instances
     */
    protected $sources = [];

    /**
     * @var array Local cache of paths available in the sources
     */
    protected $pathCache = [];

    /**
     * @var bool Flag on whether the cache should respect refresh requests
     */
    protected $allowCacheRefreshes = true;

    /**
     * @var string The key for the source to perform CRUD operations on
     */
    public $activeSourceKey = '';

    /**
     * Create a new source instance.
     *
     * @param array $sources
     */
    public function __construct(array $sources)
    {
        $this->sources = $sources;
        $this->activeSourceKey = array_keys($sources)[0];

        $this->populateCache();

        $this->finder = new Finder;
        $this->processor = new Processor;
    }

    /**
     * Populate the local cache of paths available in each source
     *
     * @param bool $refresh Default false, set to true to force the cache to be rebuilt
     * @return void
     */
    protected function populateCache($refresh = false)
    {
        $pathCache = [];
        foreach ($this->sources as $source) {
            $cacheKey = $source->getPathsCacheKey();

            // Remove any existing cache data
            if ($refresh && $this->allowCacheRefreshes)
                Cache::forget($cacheKey);

            // Load the cache
            $pathCache[] = Cache::rememberForever($cacheKey, function () use ($source) {
                return $source->getAvailablePaths();
            });
        }

        $this->pathCache = $pathCache;
    }

    /**
     * Get the source for use with CRUD operations
     *
     * @return SourceInterface
     */
    protected function getActiveSource()
    {
        return $this->sources[$this->activeSourceKey];
    }

    /**
     * Get the appropriate source for the provided path
     *
     * @param string $path
     * @return \Igniter\Flame\Pagic\Source\SourceInterface
     */
    protected function getSourceForPath(string $path)
    {
        // Default to the first source provided
        $sourceIndex = 0;

        foreach ($this->pathCache as $index => $paths) {
            if (in_array($path, $paths)) {
                $sourceIndex = $index;

                // Break on first source that can handle the path
                break;
            }
        }

        return $this->sources[$sourceIndex];
    }

    /**
     * Helper to make file path.
     *
     * @param string $dirName
     * @param string $fileName
     * @param string $extension
     * @return string
     */
    protected function makeFilePath(string $dirName, string $fileName, string $extension)
    {
        return $dirName.'/'.$fileName.'.'.$extension;
    }

    /**
     * Returns a single source.
     *
     * @param  string $dirName
     * @param  string $fileName
     * @param  string $extension
     *
     * @return mixed
     */
    public function select($dirName, $fileName, $extension)
    {
        try {
            $result = $this->getSourceForPath(
                $this->makeFilePath($dirName, $fileName, $extension)
            )->select($dirName, $fileName, $extension);
        }
        catch (Exception $ex) {
            $result = null;
        }

        return $result;
    }

    /**
     * Returns all sources.
     *
     * @param  string $dirName
     * @param  array $options
     *
     * @return array
     */
    public function selectAll($dirName, array $options = [])
    {
        $sourceResults = array_map(function (SourceInterface $source) use ($dirName, $options) {
            return $source->selectAll($dirName, $options);
        }, array_reverse($this->sources));

        $results = array_merge([], ...$sourceResults);

        // Remove duplicate results prioritizing results from earlier sources
        $results = collect($results)->keyBy('fileName')->values()->all();

        return $results;
    }

    /**
     * Creates a new source.
     *
     * @param  string $dirName
     * @param  string $fileName
     * @param  string $extension
     * @param  string $content
     *
     * @return bool
     */
    public function insert($dirName, $fileName, $extension, $content)
    {
        $result = $this->getActiveSource()->insert($dirName, $fileName, $extension, $content);

        // Refresh the cache
        $this->populateCache(true);

        return $result;
    }

    /**
     * Updates an existing source.
     *
     * @param  string $dirName
     * @param  string $fileName
     * @param  string $extension
     * @param  string $content
     * @param string $oldFileName
     * @param string $oldExtension
     *
     * @return int
     */
    public function update($dirName, $fileName, $extension, $content, $oldFileName = null, $oldExtension = null)
    {
        $searchFileName = $oldFileName ?: $fileName;
        $searchExt = $oldExtension ?: $extension;

        // Ensure that files that are being renamed have their old names marked as deleted prior to inserting the renamed file
        // Also ensure that the cache only gets updated at the end of this operation instead of twice, once here and again at the end
        if ($searchFileName !== $fileName || $searchExt !== $extension) {
            $this->allowCacheRefreshes = false;
            $this->delete($dirName, $searchFileName, $searchExt);
            $this->allowCacheRefreshes = true;
        }

        $source = $this->getActiveSource();

        if (!empty($source->select($dirName, $searchFileName, $searchExt))) {
            $result = $source->update($dirName, $fileName, $extension, $content, $oldFileName, $oldExtension);
        }
        else {
            $result = $source->insert($dirName, $fileName, $extension, $content);
        }

        // Refresh the cache
        $this->populateCache(true);

        return $result;
    }

    /**
     * Run a delete statement against the source.
     *
     * @param  string $dirName
     * @param  string $fileName
     * @param  string $extension
     *
     * @return int
     */
    public function delete($dirName, $fileName, $extension)
    {
        // Delete from only the active source
        $this->getActiveSource()->delete($dirName, $fileName, $extension);

        // Refresh the cache
        $this->populateCache(true);
    }

    /**
     * Return the last modified date of an object
     *
     * @param  string $dirName
     * @param  string $fileName
     * @param  string $extension
     *
     * @return int
     */
    public function lastModified($dirName, $fileName, $extension)
    {
        return $this->getSourceForPath(
            $this->makeFilePath($dirName, $fileName, $extension)
        )->lastModified($dirName, $fileName, $extension);
    }

    /**
     * Generate a cache key unique to this source.
     *
     * @param  string $name
     *
     * @return string
     */
    public function makeCacheKey($name = '')
    {
        $key = '';
        foreach ($this->sources as $source) {
            $key .= $source->makeCacheKey($name).'-';
        }
        $key .= $name;

        return crc32($key);
    }

    /**
     * Generate a paths cache key unique to this source
     *
     * @return string
     */
    public function getPathsCacheKey()
    {
        return 'pagic-source-chain';
    }

    /**
     * Get all available paths within this source
     *
     * @return array $paths ['path/to/file1.md' => true (path can be handled and exists), 'path/to/file2.md' => false (path can be handled but doesn't exist)]
     */
    public function getAvailablePaths()
    {
        return collect($this->sources)->mapWithKeys(function (SourceInterface $source) {
            return $source->getAvailablePaths();
        })->toArray();
    }
}
