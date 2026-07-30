<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

interface DistanceInterface
{
    /**
     * Set the origin coordinate
     */
    public function setFrom(CoordinatesInterface $from): self;

    /**
     * Get the origin coordinate
     */
    public function getFrom(): CoordinatesInterface;

    /**
     * Set the destination coordinate
     */
    public function setTo(CoordinatesInterface $to): self;

    /**
     * Get the destination coordinate
     */
    public function getTo(): CoordinatesInterface;

    /**
     * Set the user unit
     */
    public function in(string $unit): self;

    /**
     * Get the user unit
     */
    public function getUnit(): string;

    public function withData(string $name, mixed $value): self;

    public function getData(string $name, mixed $default = null): mixed;

    public function haversine(): int|float;
}
