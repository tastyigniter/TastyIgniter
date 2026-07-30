<?php

declare(strict_types=1);

namespace Igniter\System\Traits;

trait CacheMaker
{
    /**
     * Retrieves key/value pair from cache data.
     */
    public function getCache(?string $key = null, mixed $default = null): mixed
    {
        return cache()->get($this->makeCacheKey($key), $default);
    }

    /**
     * Saves key/value pair in to cache data.
     */
    public function putCache(string $key, mixed $value): void
    {
        cache()->put($this->makeCacheKey($key), $value);
    }

    public function hasCache(string $key): bool
    {
        return cache()->has($this->makeCacheKey($key));
    }

    public function forgetCache(string $key): void
    {
        cache()->forget($this->makeCacheKey($key));
    }

    public function resetCache(): void
    {
        cache()->forget($this->makeCacheKey());
    }

    public function getCacheKey(): string
    {
        return get_class_id($this::class);
    }

    /**
     * Returns a unique cache identifier for this location.
     */
    protected function makeCacheKey(?string $key = null): string
    {
        return $this->getCacheKey().($key ? '.'.$key : '');
    }
}
