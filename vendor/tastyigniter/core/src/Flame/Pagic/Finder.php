<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic;

use BadMethodCallException;
use DateTime;
use Igniter\Flame\Pagic\Exception\InvalidExtensionException;
use Igniter\Flame\Pagic\Exception\InvalidFileNameException;
use Igniter\Flame\Pagic\Exception\MissingFileNameException;
use Igniter\Flame\Pagic\Processors\Processor;
use Igniter\Flame\Pagic\Source\MemorySource;
use Igniter\Flame\Pagic\Source\SourceInterface;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class Finder
{
    /**
     * The model being queried.
     */
    protected Model $model;

    /**
     * Filter by these file extensions.
     */
    public ?array $extensions = null;

    /**
     * The columns that should be returned.
     */
    public array $columns = ['*'];

    /**
     * The directory name which the finder is targeting.
     */
    public string $in;

    /**
     * Query should pluck a single record.
     */
    public array $select = [];

    /**
     * Match files using the specified pattern.
     */
    public ?string $fileMatch = null;

    /**
     * The maximum number of records to return.
     */
    public int $limit = 0;

    /**
     * The number of records to skip.
     */
    public int $offset = 0;

    /**
     * The key that should be used when caching the query.
     */
    protected ?string $cacheKey = null;

    /**
     * The number of seconds to cache the query.
     */
    protected ?int $cacheSeconds = null;

    /**
     * The tags for the query cache.
     */
    protected array $cacheTags = [];

    /**
     * The cache driver to be used.
     */
    protected ?string $cacheDriver = null;

    /**
     * Internal variable to specify if the record was loaded from cache.
     */
    protected bool $loadedFromCache = false;

    /**
     * Create a new query finder instance.
     */
    public function __construct(
        protected SourceInterface $source,
        protected Processor $processor,
    ) {}

    /**
     * Switches mode to select a single template by its name.
     */
    public function whereFileName(string $fileName): static
    {
        $this->select = $this->model->getFileNameParts($fileName);

        return $this;
    }

    /**
     * Set the directory name which the finder is targeting.
     */
    public function in(string $dirName): static
    {
        $this->in = $dirName;

        return $this;
    }

    /**
     * Set the "offset" value of the query.
     */
    public function offset(int $value): static
    {
        $this->offset = max(0, $value);

        return $this;
    }

    /**
     * Alias to set the "offset" value of the query.
     */
    public function skip(int $value): static
    {
        return $this->offset($value);
    }

    /**
     * Set the "limit" value of the query.
     */
    public function limit(int $value): static
    {
        if ($value >= 0) {
            $this->limit = $value;
        }

        return $this;
    }

    /**
     * Alias to set the "limit" value of the query.
     */
    public function take(int $value): static
    {
        return $this->limit($value);
    }

    /**
     * Find a single template by its file name.
     */
    public function find(string $fileName): ?Model
    {
        return $this->whereFileName($fileName)->first();
    }

    /**
     * Execute the query and get the first result.
     */
    public function first(): ?Model
    {
        return $this->limit(1)->get()->first();
    }

    /**
     * Execute the query as a "select" statement.
     */
    public function get(array $columns = ['*']): Collection
    {
        $results = !is_null($this->cacheSeconds) ? $this->getCached($columns) : $this->getFresh($columns);

        $models = $this->getModels($results ?: []);

        return $this->model->newCollection($models);
    }

    /**
     * Get an array with the values of a given column.
     */
    public function lists(string $column, ?string $key = null): Collection
    {
        $select = is_null($key) ? [$column] : [$column, $key];

        $collection = $this->get($select);

        return $collection->pluck($column, $key);
    }

    /**
     * Insert a new record into the source.
     */
    public function insert(array $values): bool
    {
        if (empty($values)) {
            return true;
        }

        $this->validateFileName();

        [$name, $extension] = $this->model->getFileNameParts();

        $result = $this->processor->processInsert($this, $values);

        return $this->source->insert(
            $this->model->getTypeDirName(),
            $name,
            $extension,
            $result,
        );
    }

    /**
     * Update a record in the source.
     */
    public function update(array $values): bool
    {
        $this->validateFileName();

        [$name, $extension] = $this->model->getFileNameParts();

        $result = $this->processor->processUpdate($this, $values);
        $oldName = null;
        $oldExtension = null;

        if ($this->model->isDirty('fileName')) {
            [$oldName, $oldExtension] = $this->model->getFileNameParts(
                $this->model->getOriginal('fileName'),
            );
        }

        return $this->source->update(
            $this->model->getTypeDirName(),
            $name,
            $extension,
            $result,
            $oldName,
            $oldExtension,
        );
    }

    /**
     * Delete a source from the filesystem.
     */
    public function delete(): bool
    {
        $this->validateFileName();

        [$name, $extension] = $this->model->getFileNameParts();

        return $this->source->delete(
            $this->model->getTypeDirName(),
            $name,
            $extension,
        );
    }

    /**
     * Returns the last modified time of the object.
     */
    public function lastModified(): int
    {
        $this->validateFileName();

        [$name, $extension] = $this->model->getFileNameParts();

        return $this->source->lastModified(
            $this->model->getTypeDirName(),
            $name,
            $extension,
        );
    }

    /**
     * Execute the query as a fresh "select" statement.
     */
    public function getFresh(array $columns = ['*']): ?array
    {
        $this->columns = $columns;

        $processCmd = $this->select ? 'processSelect' : 'processSelectAll';

        return $this->processor->{$processCmd}($this, $this->runSelect());
    }

    /**
     * Run the query as a "select" statement against the source.
     */
    protected function runSelect(): ?array
    {
        if ($this->select) {
            [$name, $extension] = $this->select;

            return $this->source->select($this->in, $name, $extension);
        }

        return $this->source->selectAll($this->in, [
            'columns' => $this->columns,
            'extensions' => $this->extensions,
        ]);
    }

    /**
     * Set a model instance for the model being queried.
     */
    public function setModel(Model $model): static
    {
        $this->model = $model;

        $this->in($this->model->getTypeDirName());

        return $this;
    }

    /**
     * Get the hydrated models.
     *
     * @return Model[]
     */
    public function getModels(array $results): array
    {
        $source = $this->model->getSourceName();

        $models = $this->model->hydrate($results, $source);

        // Flag the models as loaded from cache, then reset the internal property.
        if ($this->loadedFromCache) {
            $models->each(function(Model $model) {
                $model->setLoadedFromCache($this->loadedFromCache);
            });

            $this->loadedFromCache = false;
        }

        return $models->all();
    }

    /**
     * Get the model instance being queried.
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    public function getSource(): SourceInterface
    {
        return $this->source;
    }

    //
    // Validation
    //

    /**
     * Validate the supplied filename, extension and path.
     */
    protected function validateFileName(?string $fileName = null): bool
    {
        if ($fileName === null) {
            $fileName = $this->model->fileName;
        }

        if (!$fileName) {
            throw (new MissingFileNameException)->setModel($this->model::class);
        }

        if (!$this->validateFileNamePath($fileName, $this->model->getMaxNesting())) {
            throw (new InvalidFileNameException)->setInvalidFileName($fileName);
        }

        $this->validateFileNameExtension($fileName, Model::DEFAULT_EXTENSION);

        return true;
    }

    /**
     * Validates whether a file has an allowed extension.
     */
    protected function validateFileNameExtension(string $fileName, string $allowedExtension)
    {
        if (!str_ends_with($fileName, '.'.$allowedExtension)) {
            throw new InvalidExtensionException($fileName, $allowedExtension);
        }
    }

    /**
     * Validates a template path.
     * Template directory and file names can contain only alphanumeric symbols, dashes and dots.
     */
    protected function validateFileNamePath(string $filePath, int $maxNesting = 2): bool
    {
        if (str_contains($filePath, '..')) {
            return false;
        }

        if (starts_with($filePath, './') || starts_with($filePath, '//')) {
            return false;
        }

        $segments = explode(DIRECTORY_SEPARATOR, $filePath);
        if (count($segments) > $maxNesting) {
            return false;
        }

        foreach ($segments as $segment) {
            if (!preg_match('/^[a-z0-9\_\-\.\/]+$/i', $segment)) {
                return false;
            }
        }

        return true;
    }

    //
    // Caching
    //

    /**
     * Indicate that the query results should be cached.
     */
    public function remember(DateTime|int|null $seconds, ?string $key = null): static
    {
        [$this->cacheSeconds, $this->cacheKey] = [$seconds, $key];

        return $this;
    }

    /**
     * Indicate that the query results should be cached forever.
     */
    public function rememberForever(?string $key = null): static
    {
        return $this->remember(-1, $key);
    }

    /**
     * Indicate that the results, if cached, should use the given cache tags.
     */
    public function cacheTags(array $cacheTags): static
    {
        $this->cacheTags = $cacheTags;

        return $this;
    }

    /**
     * Indicate that the results, if cached, should use the given cache driver.
     */
    public function cacheDriver(string $cacheDriver): static
    {
        $this->cacheDriver = $cacheDriver;

        return $this;
    }

    /**
     * Execute the query as a cached "select" statement.
     */
    public function getCached(array $columns = ['*']): array
    {
        $this->columns = $columns;

        $key = $this->getCacheKey();

        if (array_key_exists($key, MemorySource::$cache)) {
            return MemorySource::$cache[$key];
        }

        $seconds = $this->cacheSeconds;
        $cache = $this->getCache();
        $callback = $this->getCacheCallback($columns);
        $isNewCache = !$cache->has($key);

        // If the "seconds" value is less than zero, we will use that as the indicator
        // that the value should be remembered values should be stored indefinitely
        // and if we have seconds we will use the typical remember function here.
        $result = $seconds < 0 ? $cache->rememberForever($key, $callback) : $cache->remember($key, $seconds, $callback);

        // If this is an old cache record, we can check if the cache has been busted
        // by comparing the modification times. If this is the case, forget the
        // cache and then prompt a recycle of the results.
        if (!$isNewCache && $this->isCacheBusted($result)) {
            $cache->forget($key);
            $isNewCache = true;

            $result = $seconds < 0 ? $cache->rememberForever($key, $callback) : $cache->remember($key, $seconds, $callback);
        }

        $this->loadedFromCache = !$isNewCache;

        return MemorySource::$cache[$key] = $result;
    }

    /**
     * Returns true if the cache for the file is busted. This only applies
     * to single record selection.
     */
    protected function isCacheBusted(array $result): bool
    {
        if (!$this->select) {
            return false;
        }

        $mTime = !empty($result) ? array_get(reset($result), 'mTime') : null;

        [$name, $extension] = $this->select;

        $lastMTime = $this->source->lastModified(
            $this->in,
            $name,
            $extension,
        );

        return $lastMTime != $mTime;
    }

    /**
     * Get the cache object with tags assigned, if applicable.
     */
    protected function getCache(): Repository
    {
        $cache = $this->model->getCacheManager()->driver($this->cacheDriver);

        return $this->cacheTags ? $cache->tags($this->cacheTags) : $cache;
    }

    /**
     * Get a unique cache key for the complete query.
     */
    public function getCacheKey(): string
    {
        return $this->cacheKey ?: $this->generateCacheKey();
    }

    /**
     * Generate the unique cache key for the query.
     */
    public function generateCacheKey(): string
    {
        $payload = [];
        $payload[] = $this->select ? serialize($this->select) : '*';
        $payload[] = $this->columns ? serialize($this->columns) : '*';
        $payload[] = $this->fileMatch;
        $payload[] = $this->limit;
        $payload[] = $this->offset;

        return $this->in.$this->source->makeCacheKey(implode('-', $payload));
    }

    protected function getCacheCallback(array $columns): callable
    {
        return fn(): array => $this->processInitCacheData($this->getFresh($columns));
    }

    /**
     * Initialize the cache data of each record.
     */
    protected function processInitCacheData(array $data): array
    {
        if (!empty($data)) {
            $model = $this->model::class;

            foreach ($data as &$record) {
                $model::initCacheItem($record);
            }
        }

        return $data;
    }

    /**
     * Clears the internal request-level object cache.
     */
    public static function clearInternalCache(): void
    {
        MemorySource::$cache = [];
    }

    public function __call(string $method, ?array $parameters): mixed
    {
        $className = static::class;

        throw new BadMethodCallException(sprintf('Call to undefined method %s::%s()', $className, $method));
    }
}
