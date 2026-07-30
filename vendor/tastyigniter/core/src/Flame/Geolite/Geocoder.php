<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite;

use Igniter\Flame\Geolite\Contracts\AbstractProvider;
use Igniter\Flame\Geolite\Contracts\GeocoderInterface;
use Igniter\Flame\Geolite\Contracts\GeoQueryInterface;
use Igniter\Flame\Geolite\Provider\ChainProvider;
use Igniter\Flame\Geolite\Provider\GoogleProvider;
use Igniter\Flame\Geolite\Provider\NominatimProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Manager;
use InvalidArgumentException;
use Override;

class Geocoder extends Manager implements GeocoderInterface
{
    protected int $limit = 0;

    protected ?string $locale = null;

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function locale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    #[Override]
    public function geocode(string $address): Collection
    {
        $query = GeoQuery::create($address);

        if ($this->limit !== 0) {
            $query = $query->withLimit($this->limit);
        }

        if ($this->locale) {
            $query = $query->withLocale($this->locale);
        }

        return $this->geocodeQuery($query);
    }

    #[Override]
    public function reverse(int|float $latitude, int|float $longitude): Collection
    {
        $query = GeoQuery::fromCoordinates($latitude, $longitude);

        if ($this->limit !== 0) {
            $query = $query->withLimit($this->limit);
        }

        if ($this->locale) {
            $query = $query->withLocale($this->locale);
        }

        return $this->reverseQuery($query);
    }

    public function geocodeQuery(GeoQueryInterface $query): Collection
    {
        $limit = $query->getLimit();
        if (!$limit && $this->limit) {
            $query = $query->withLimit($this->limit);
        }

        $locale = $query->getLocale();
        if (!$locale && $this->locale) {
            $query = $query->withLocale($this->locale);
        }

        return $this->driver()->geocodeQuery($query);
    }

    public function reverseQuery(GeoQueryInterface $query): Collection
    {
        $limit = $query->getLimit();
        if (!$limit && $this->limit) {
            $query = $query->withLimit($this->limit);
        }

        $locale = $query->getLocale();
        if (!$locale && $this->locale) {
            $query = $query->withLocale($this->locale);
        }

        return $this->driver()->reverseQuery($query);
    }

    public function using(string $name): AbstractProvider
    {
        return $this->driver($name);
    }

    /**
     * Get a driver instance.
     *
     * @param string $driver
     */
    #[Override]
    public function driver($driver = null): AbstractProvider
    {
        $driver = $driver ?: $this->getDefaultDriver();

        return $this->makeProvider($driver);
    }

    #[Override]
    public function makeProvider(string $name): AbstractProvider
    {
        return $this->drivers[$name] ?? ($this->drivers[$name] = $this->createProvider($name));
    }

    /**
     * Get the default driver name.
     */
    #[Override]
    public function getDefaultDriver(): string
    {
        return $this->container['config']['igniter-geocoder.default'] ?? 'nominatim';
    }

    protected function createProvider(string $name): AbstractProvider
    {
        if (isset($this->customCreators[$name])) {
            return $this->callCustomCreator($name);
        }

        $method = 'create'.studly_case($name).'Provider';
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new InvalidArgumentException(sprintf('Provider [%s] not supported.', $name));
    }

    protected function createChainProvider(): AbstractProvider
    {
        $providers = $this->container['config']['igniter-geocoder.providers'];

        return new ChainProvider($this, $providers);
    }

    protected function createNominatimProvider(): AbstractProvider
    {
        $config = $this->container['config']['igniter-geocoder.providers.nominatim'];

        return new NominatimProvider($this->container['geocoder.client'], $config);
    }

    protected function createGoogleProvider(): AbstractProvider
    {
        $config = $this->container['config']['igniter-geocoder.providers.google'];

        return new GoogleProvider($this->container['geocoder.client'], $config);
    }
}
