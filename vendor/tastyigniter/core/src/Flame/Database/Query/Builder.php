<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Query;

use Closure;
use DateTime;
use Igniter\Flame\Database\Connections\Connection;
use Igniter\Flame\Database\MemoryCache;
use Illuminate\Cache\CacheManager;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Override;

/**
 * Adapted from october\rain\database\QueryBuilder
 * @property Connection $connection
 */
class Builder extends IlluminateQueryBuilder
{
    /**
     * The key that should be used when caching the query.
     *
     * @var string
     */
    protected $cacheKey;

    /**
     * The number of minutes to cache the query.
     *
     * @var int
     */
    protected $cacheMinutes;

    /**
     * The tags for the query cache.
     *
     * @var array
     */
    protected $cacheTags;

    /**
     * Indicates whether duplicate queries are being cached in memory.
     *
     * @var bool
     */
    protected $cachingDuplicateQueries = false;

    /**
     * Get an array with the values of a given column.
     *
     * @param string $column
     * @param string|null $key
     * @return array
     */
    public function lists($column, $key = null)
    {
        return $this->pluck($column, $key)->all();
    }

    /**
     * Indicate that the query results should be cached.
     *
     * @param DateTime|int $minutes
     * @param string $key
     */
    public function remember($minutes, $key = null): static
    {
        $this->cacheMinutes = $minutes;
        $this->cacheKey = $key;

        return $this;
    }

    /**
     * Indicate that the query results should be cached forever.
     *
     * @param string $key
     */
    public function rememberForever($key = null): static
    {
        return $this->remember(-1, $key);
    }

    /**
     * Indicate that the results, if cached, should use the given cache tags.
     *
     * @param array|mixed $cacheTags
     */
    public function cacheTags($cacheTags): static
    {
        $this->cacheTags = $cacheTags;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function get($columns = ['*'])
    {
        if ($this->cachingDuplicates()) {
            return $this->getDuplicateCached($columns);
        }

        if (!is_null($this->cacheMinutes)) {
            return $this->getCached($columns);
        }

        return parent::get($columns);
    }

    /**
     * Check the memory cache before executing the query
     *
     * @param array $columns
     * @return Collection
     */
    protected function getDuplicateCached($columns = ['*'])
    {
        if (is_null($this->columns)) {
            $this->columns = $columns;
        }

        $cache = resolve(MemoryCache::class);
        if ($cache->has($this)) {
            $results = collect($cache->get($this));
        } else {
            $results = !is_null($this->cacheMinutes) ? $this->getCached($columns) : parent::get($columns);

            $cache->put($this, $results->all());
        }

        return $results;
    }

    /**
     * Execute the query as a cached "select" statement.
     *
     * @param array $columns
     */
    public function getCached($columns = ['*']): Collection
    {
        if (is_null($this->columns)) {
            $this->columns = $columns;
        }

        // If the query is requested to be cached, we will cache it using a unique key
        // for this database connection and query statement, including the bindings
        // that are used on this query, providing great convenience when caching.
        [$key, $minutes] = $this->getCacheInfo();

        $cache = $this->getCache();

        $callback = $this->getCacheCallback($columns);

        // If the "minutes" value is less than zero, we will use that as the indicator
        // that the value should be remembered values should be stored indefinitely
        // and if we have minutes we will use the typical remember function here.
        if (is_int($minutes) && $minutes < 0) {
            $results = $cache->rememberForever($key, $callback);
        } else {
            $expiresAt = is_int($minutes) ? now()->addMinutes($minutes) : $minutes;
            $results = $cache->remember($key, $expiresAt, $callback);
        }

        return collect($results);
    }

    /**
     * Get the cache object with tags assigned, if applicable.
     *
     * @return CacheManager
     */
    protected function getCache()
    {
        $cache = App::make('cache');

        return $this->cacheTags ? $cache->tags($this->cacheTags) : $cache;
    }

    /**
     * Get the cache key and cache minutes as an array.
     */
    protected function getCacheInfo(): array
    {
        return [$this->getCacheKey(), $this->cacheMinutes];
    }

    /**
     * Get a unique cache key for the complete query.
     *
     * @return string
     */
    public function getCacheKey()
    {
        return $this->cacheKey ?: $this->generateCacheKey();
    }

    /**
     * Generate the unique cache key for the query.
     */
    public function generateCacheKey(): string
    {
        $name = $this->connection->getName();

        return md5($name.$this->toSql().serialize($this->getBindings()));
    }

    /**
     * Get the Closure callback used when caching queries.
     *
     * @param array $columns
     * @return Closure
     */
    protected function getCacheCallback($columns)
    {
        return fn() => parent::get($columns)->all();
    }

    /**
     * Retrieve the "count" result of the query,
     * also strips off any orderBy clause.
     *
     * @param string $columns
     * @return int
     */
    #[Override]
    public function count($columns = '*')
    {
        $previousOrders = $this->orders;

        $this->orders = null;

        $result = parent::count($columns);

        $this->orders = $previousOrders;

        return $result;
    }

    /**
     * Update a record in the database.
     *
     * @return int
     */
    #[Override]
    public function update(array $values)
    {
        $this->clearDuplicateCache();

        return parent::update($values);
    }

    /**
     * Delete a record from the database.
     *
     * @param mixed $id
     * @return int
     */
    #[Override]
    public function delete($id = null)
    {
        $this->clearDuplicateCache();

        return parent::delete($id);
    }

    /**
     * Insert a new record and get the value of the primary key.
     *
     * @param string $sequence
     * @return int
     */
    #[Override]
    public function insertGetId(array $values, $sequence = null)
    {
        $this->clearDuplicateCache();

        return parent::insertGetId($values, $sequence);
    }

    /**
     * Insert a new record into the database.
     *
     * @return bool
     */
    #[Override]
    public function insert(array $values)
    {
        $this->clearDuplicateCache();

        return parent::insert($values);
    }

    /**
     * Run a truncate statement on the table.
     */
    #[Override]
    public function truncate(): void
    {
        $this->clearDuplicateCache();

        parent::truncate();
    }

    /**
     * Clear memory cache for the given table.
     *
     * @param string|null $table
     */
    public function clearDuplicateCache($table = null): static
    {
        resolve(MemoryCache::class)->forget($table ?: $this->from);

        return $this;
    }

    /**
     * Flush the memory cache.
     */
    public function flushDuplicateCache(): static
    {
        resolve(MemoryCache::class)->flush();

        return $this;
    }

    /**
     * Enable the memory cache on the query.
     */
    public function enableDuplicateCache(): static
    {
        $this->cachingDuplicateQueries = true;

        return $this;
    }

    /**
     * Disable the memory cache on the query.
     */
    public function disableDuplicateCache(): static
    {
        $this->cachingDuplicateQueries = false;

        return $this;
    }

    /**
     * Determine whether we're caching duplicate queries.
     *
     * @return bool
     */
    public function cachingDuplicates()
    {
        return $this->cachingDuplicateQueries;
    }
}
