<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

use Igniter\Flame\Geolite\Model\CoordinatesCollection;

interface PolygonInterface
{
    /**
     * Returns the geometry type.
     */
    public function getGeometryType(): string;

    /**
     * Returns the precision of the geometry.
     */
    public function getPrecision(): ?int;

    /**
     *  Returns a vertex of this <code>Geometry</code> (usually, but not necessarily, the first one).
     *  The returned coordinate should not be assumed to be an actual Coordinate object used in
     *  the internal representation.
     */
    public function getCoordinate(): ?CoordinatesInterface;

    /**
     *  Returns a collection containing the values of all the vertices for this geometry.
     *  If the geometry is a composite, the array will contain all the vertices
     *  for the components, in the order in which the components occur in the geometry.
     */
    public function getCoordinates(): CoordinatesCollection;

    /**
     * Returns true if the geometry is empty.
     */
    public function isEmpty(): bool;

    /**
     * Returns the bounding box of the Geometry
     */
    public function getBounds(): BoundsInterface;

    public function pointInPolygon(CoordinatesInterface $coordinate): bool;

    public function pointOnBoundary(CoordinatesInterface $coordinate): bool;

    public function pointOnVertex(CoordinatesInterface $coordinate): bool;
}
