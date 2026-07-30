<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Model;

use Igniter\Flame\Geolite\Distance as GeoliteDistance;
use Igniter\Flame\Geolite\Geolite;

class Distance
{
    public function __construct(protected float $distance, protected float $duration) {}

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function formatDistance(string $unit = Geolite::MILE_UNIT): float
    {
        return (new GeoliteDistance)->in($unit)->convertToUserUnit($this->distance);
    }

    public function formatDuration(string $unit = Geolite::MILE_UNIT): string
    {
        return now()->diffForHumans(now()->addSeconds($this->duration));
    }
}
