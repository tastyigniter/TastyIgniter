<?php

declare(strict_types=1);

namespace Igniter\Local\Contracts;

use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;

interface LocationInterface
{
    public function getName();

    public function getEmail();

    public function getTelephone();

    public function getDescription();

    public function getAddress();

    public function calculateDistance(CoordinatesInterface $position);
}
