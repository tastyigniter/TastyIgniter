<?php

declare(strict_types=1);

namespace Igniter\Flame\Database;

use Igniter\Flame\Database\Connections\Connection;
use Igniter\Flame\Database\Query\Builder as QueryBuilder;

/**
 * Query memory cache class.
 *
 * Stores query results in memory to avoid running duplicate queries
 *
 * Adapted from october\rain\database\MemoryCache
 */
class MemoryCache
{
    /**
     * Cached results.
     *
     * @var array
     */
    protected $cache = [];

    /**
     * The mapper between hashed keys and table names.
     *
     * @var array
     */
    protected $tableMap = [];

    /**
     * @var bool Store enabled state.
     */
    protected $enabled = true;

    /**
     * Check if the memory cache is enabled.
     *
     * @return bool
     */
    public function enabled($switch = null)
    {
        if ($switch !== null) {
            $this->enabled = $switch;
        }

        return $this->enabled;
    }

    /**
     * Check if the given query is cached.
     */
    public function has(QueryBuilder $query): bool
    {
        return $this->enabled && isset($this->cache[$this->hash($query)]);
    }

    /**
     * Get the cached results for the given query.
     *
     * @return array|null
     */
    public function get(QueryBuilder $query)
    {
        if ($this->has($query)) {
            return $this->cache[$this->hash($query)];
        }

        return null;
    }

    /**
     * Store the results for the given query.
     */
    public function put(QueryBuilder $query, array $results): void
    {
        if (!$this->enabled) {
            return;
        }

        $hash = $this->hash($query);

        $this->cache[$hash] = $results;

        $this->tableMap[(string)$query->from][] = $hash;
    }

    /**
     * Delete the cache for the given table.
     *
     * @param string $table
     */
    public function forget($table): void
    {
        if (!isset($this->tableMap[$table])) {
            return;
        }

        foreach ($this->tableMap[$table] as $hash) {
            unset($this->cache[$hash]);
        }

        unset($this->tableMap[$table]);
    }

    /**
     * Clear the memory cache.
     */
    public function flush(): void
    {
        $this->cache = [];
        $this->tableMap = [];
    }

    /**
     * Calculate a hash key for the given query.
     */
    protected function hash(QueryBuilder $query): string
    {
        // First we will cast all bindings to string, so we can ensure the same
        // hash format regardless of the binding type provided by the user.
        $bindings = array_map(fn($binding): string => (string)$binding, $query->getBindings());

        /** @var Connection $connection */
        $connection = $query->getConnection();
        $name = $connection->getName();

        return md5($name.$query->toSql().serialize($bindings));
    }
}
