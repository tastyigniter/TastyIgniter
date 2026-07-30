<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

use Illuminate\Support\Collection;

interface GeocoderInterface
{
    /**
     * The default result limit.
     */
    public const DEFAULT_RESULT_LIMIT = 5;

    public function geocode(string $address): Collection;

    public function reverse(float $latitude, float $longitude): Collection;

    public function makeProvider(string $name): AbstractProvider;
}
