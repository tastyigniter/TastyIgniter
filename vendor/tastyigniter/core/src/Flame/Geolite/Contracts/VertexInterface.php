<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

interface VertexInterface
{
    /**
     * Set the origin coordinate.
     */
    public function setFrom(CoordinatesInterface $from): VertexInterface;

    /**
     * Get the origin coordinate.
     */
    public function getFrom(): CoordinatesInterface;

    /**
     * Set the destination coordinate.
     */
    public function setTo(CoordinatesInterface $to): VertexInterface;

    /**
     * Get the destination coordinate.
     */
    public function getTo(): CoordinatesInterface;

    /**
     * Get the gradient (slope) of the vertex.
     */
    public function getGradient(): ?float;

    /**
     * Get the ordinate (longitude) of the point where vertex intersects with the ordinate-axis
     * (Prime-Meridian) of the coordinate system.
     */
    public function getOrdinateIntercept(): ?float;
}
