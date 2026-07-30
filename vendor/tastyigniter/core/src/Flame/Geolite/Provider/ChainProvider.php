<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Provider;

use Igniter\Flame\Geolite\Contracts\AbstractProvider;
use Igniter\Flame\Geolite\Contracts\DistanceInterface;
use Igniter\Flame\Geolite\Contracts\GeocoderInterface;
use Igniter\Flame\Geolite\Contracts\GeoQueryInterface;
use Igniter\Flame\Geolite\Model\Coordinates;
use Igniter\Flame\Geolite\Model\Distance;
use Illuminate\Support\Collection;
use Override;

class ChainProvider extends AbstractProvider
{
    public function __construct(protected GeocoderInterface $geocoder, protected array $providers = []) {}

    #[Override]
    public function getName(): string
    {
        return 'Chain';
    }

    #[Override]
    public function geocodeQuery(GeoQueryInterface $query): Collection
    {
        foreach (array_keys($this->providers) as $name) {
            $provider = $this->geocoder->makeProvider($name);
            $result = $provider->geocodeQuery($query);
            if ($result->isNotEmpty()) {
                return $result;
            }
        }

        return new Collection;
    }

    #[Override]
    public function reverseQuery(GeoQueryInterface $query): Collection
    {
        foreach (array_keys($this->providers) as $name) {
            $provider = $this->geocoder->makeProvider($name);
            $result = $provider->reverseQuery($query);
            if ($result->isNotEmpty()) {
                return $result;
            }
        }

        return new Collection;
    }

    #[Override]
    public function distance(DistanceInterface $distance): ?Distance
    {
        foreach (array_keys($this->providers) as $name) {
            $result = $this->geocoder->makeProvider($name)->distance($distance);
            if (!is_null($result)) {
                return $result;
            }
        }

        return null;
    }

    #[Override]
    public function placesAutocomplete(GeoQueryInterface $query): Collection
    {
        foreach (array_keys($this->providers) as $name) {
            $result = $this->geocoder->makeProvider($name)->placesAutocomplete($query);
            if ($result->isNotEmpty()) {
                return $result;
            }
        }

        return new Collection;
    }

    #[Override]
    public function getPlaceCoordinates(GeoQueryInterface $query): Coordinates
    {
        foreach (array_keys($this->providers) as $name) {
            $result = $this->geocoder->makeProvider($name)->getPlaceCoordinates($query);
            if (!empty($result->getLatitude()) && !empty($result->getLongitude())) {
                return $result;
            }
        }

        return new Coordinates(0, 0);
    }

    public function addProvider(string $name, array $config = []): self
    {
        $this->providers[$name] = $config;

        return $this;
    }

    #[Override]
    public function getLogs(): array
    {
        $logs = [];
        foreach (array_keys($this->providers) as $name) {
            $provider = $this->geocoder->makeProvider($name);
            $logs[] = $provider->getLogs();
        }

        return array_merge(...$logs);
    }
}
