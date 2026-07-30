<?php

declare(strict_types=1);

namespace Igniter\Local\Contracts;

use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\LocationInterface;

interface AreaInterface
{
    public function getLocationId();

    public function checkBoundary(CoordinatesInterface $coordinate);

    public function pointInVertices(CoordinatesInterface $coordinate);

    public function pointInCircle(CoordinatesInterface $coordinate);

    public function matchAddressComponents(LocationInterface $position);
}
