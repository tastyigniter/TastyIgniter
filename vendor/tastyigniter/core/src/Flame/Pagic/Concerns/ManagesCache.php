<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Concerns;

use Illuminate\Cache\CacheManager;

trait ManagesCache
{
    /** The cache manager instance. */
    protected static ?CacheManager $cache;

    /** Indicated whether the object was loaded from the cache. */
    protected bool $loadedFromCache = false;

    /**
     * Get the cache manager instance.
     */
    public static function getCacheManager(): CacheManager
    {
        return static::$cache;
    }

    /**
     * Set the cache manager instance.
     */
    public static function setCacheManager(CacheManager $cache): void
    {
        static::$cache = $cache;
    }

    /**
     * Unset the cache manager for models.
     */
    public static function unsetCacheManager(): void
    {
        static::$cache = null;
    }

    /**
     * Initializes the object properties from the cached data. The extra data
     * set here becomes available as attributes set on the model after fetch.
     */
    public static function initCacheItem(array &$item) {}

    /**
     * Returns true if the object was loaded from the cache.
     */
    public function isLoadedFromCache(): bool
    {
        return $this->loadedFromCache;
    }

    /**
     * Returns true if the object was loaded from the cache.
     */
    public function setLoadedFromCache(bool $value): void
    {
        $this->loadedFromCache = $value;
    }
}
