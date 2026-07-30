<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

use Closure;
use GuzzleHttp\Client as HttpClient;
use Igniter\Flame\Geolite\Model\Coordinates;
use Igniter\Flame\Geolite\Model\Distance;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

abstract class AbstractProvider
{
    protected ?HttpClient $httpClient = null;

    protected ?int $cacheLifetime = null;

    protected array $logs = [];

    protected array $config = [];

    /**
     * Returns the provider name.
     */
    abstract public function getName(): string;

    /**
     * Handle the geocoder request.
     */
    abstract public function geocodeQuery(GeoQueryInterface $query): Collection;

    /**
     * Handle the reverse geocoding request.
     */
    abstract public function reverseQuery(GeoQueryInterface $query): Collection;

    abstract public function distance(DistanceInterface $distance): ?Distance;

    abstract public function placesAutocomplete(GeoQueryInterface $query): Collection;

    abstract public function getPlaceCoordinates(GeoQueryInterface $query): Coordinates;

    protected function getHttpClient(): HttpClient
    {
        return $this->httpClient ?? new HttpClient;
    }

    //
    //
    //

    /**
     * Forget the repository cache.
     */
    public function forgetCache(): self
    {
        if ($this->getCacheLifetime()) {
            // Flush cache keys, then forget actual cache
            $this->getCacheDriver()->forget($this->getCacheKey());
        }

        return $this;
    }

    public function getCacheKey(): string
    {
        return sprintf('geocode.%s', str_slug($this->getName()));
    }

    /**
     * Set the repository cache lifetime.
     */
    public function setCacheLifetime(?int $cacheLifetime): self
    {
        $this->cacheLifetime = $cacheLifetime;

        return $this;
    }

    /**
     * Get the repository cache lifetime.
     */
    public function getCacheLifetime(): ?int
    {
        $lifetime = config('igniter-geocoder.cache.duration');

        return $this->cacheLifetime ?? $lifetime;
    }

    protected function cacheCallback(string $cacheKey, Closure $closure): mixed
    {
        if (!$lifetime = $this->getCacheLifetime()) {
            return $closure();
        }

        $cacheKey = $this->getCacheKey().'@'.md5($cacheKey);

        return $this->getCacheDriver()->remember($cacheKey, $lifetime, $closure);
    }

    protected function getCacheDriver(): Repository
    {
        return Cache::store(config('igniter-geocoder.cache.store'));
    }

    //
    //
    //

    public function log(string $message): self
    {
        $this->logs[] = $message;

        return $this;
    }

    public function resetLogs(): self
    {
        $this->logs = [];

        return $this;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }
}
