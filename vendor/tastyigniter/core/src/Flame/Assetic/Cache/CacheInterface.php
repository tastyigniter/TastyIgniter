<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Cache;

/**
 * Interface for a cache backend.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
interface CacheInterface
{
    /**
     * Checks if the cache has a value for a key.
     *
     * @param string $key A unique key
     *
     * @return bool Whether the cache has a value for this key
     */
    public function has(string $key): bool;

    /**
     * Returns the value for a key.
     *
     * @param string $key A unique key
     *
     * @return string|null The value in the cache
     */
    public function get(string $key): ?string;

    /**
     * Sets a value in the cache.
     *
     * @param string $key A unique key
     * @param string $value The value to cache
     */
    public function set(string $key, string $value);

    /**
     * Removes a value from the cache.
     *
     * @param string $key A unique key
     */
    public function remove(string $key);
}
