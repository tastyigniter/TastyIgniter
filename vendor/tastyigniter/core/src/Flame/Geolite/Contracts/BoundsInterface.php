<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

interface BoundsInterface
{
    public function getNorth(): int|float;

    public function getEast(): int|float;

    public function getSouth(): int|float;

    public function getWest(): int|float;

    public function setPrecision(int $precision): self;

    public function getAsPolygon(): PolygonInterface;

    public function setPolygon(PolygonInterface $polygon);

    public function pointInBounds(CoordinatesInterface $coordinate): bool;

    public function merge(BoundsInterface $bounds): BoundsInterface;

    public function toArray(): array;
}
