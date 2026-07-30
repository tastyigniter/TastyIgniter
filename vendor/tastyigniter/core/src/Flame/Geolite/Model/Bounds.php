<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Model;

use Igniter\Flame\Geolite\Contracts\BoundsInterface;
use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\PolygonInterface;
use Igniter\Flame\Geolite\Polygon;
use Override;

class Bounds implements BoundsInterface
{
    protected int $precision = 8;

    /**
     * @param null|int|float $south South bound, also min latitude
     * @param null|int|float $west Westbound, also min longitude
     * @param null|int|float $north North bound, also max latitude
     * @param null|int|float $east Eastbound, also max longitude
     */
    final public function __construct(
        protected null|int|float $south,
        protected null|int|float $west,
        protected null|int|float $north,
        protected null|int|float $east,
    ) {
        $this->south = (float)$south;
        $this->west = (float)$west;
        $this->north = (float)$north;
        $this->east = (float)$east;
    }

    public static function fromPolygon(PolygonInterface $polygon): self
    {
        $bounds = new static(null, null, null, null);
        $bounds->setPolygon($polygon);

        return $bounds;
    }

    public function setNorth(int|float $north): self
    {
        $this->north = $north;

        return $this;
    }

    public function setEast(int|float $east): self
    {
        $this->east = $east;

        return $this;
    }

    public function setSouth(int|float $south): self
    {
        $this->south = $south;

        return $this;
    }

    public function setWest(int|float $west): self
    {
        $this->west = $west;

        return $this;
    }

    /**
     * Returns the south bound.
     */
    #[Override]
    public function getSouth(): int|float
    {
        return $this->south;
    }

    /**
     * Returns the west bound.
     */
    #[Override]
    public function getWest(): int|float
    {
        return $this->west;
    }

    /**
     * Returns the north bound.
     */
    #[Override]
    public function getNorth(): int|float
    {
        return $this->north;
    }

    /**
     * Returns the eastbound.
     */
    #[Override]
    public function getEast(): int|float
    {
        return $this->east;
    }

    public function getPrecision(): int
    {
        return $this->precision;
    }

    #[Override]
    public function setPrecision(int $precision): self
    {
        $this->precision = $precision;

        return $this;
    }

    #[Override]
    public function pointInBounds(CoordinatesInterface $coordinate): bool
    {
        return !(bccomp(
            number_format($coordinate->getLatitude(), $this->getPrecision()),
            number_format($this->getSouth(), $this->getPrecision()),
            $this->getPrecision()) === -1
            || bccomp(
                number_format($coordinate->getLatitude(), $this->getPrecision()),
                number_format($this->getNorth(), $this->getPrecision()),
                $this->getPrecision()) === 1
            || bccomp(
                number_format($coordinate->getLongitude(), $this->getPrecision()),
                number_format($this->getEast(), $this->getPrecision()),
                $this->getPrecision()) === 1
            || bccomp(
                number_format($coordinate->getLongitude(), $this->getPrecision()),
                number_format($this->getWest(), $this->getPrecision()),
                $this->getPrecision()) === -1
        );
    }

    #[Override]
    public function getAsPolygon(): PolygonInterface
    {
        $northWest = new Coordinates($this->north, $this->west);

        return new Polygon(
            new CoordinatesCollection([
                $northWest,
                new Coordinates($this->north, $this->east),
                new Coordinates($this->south, $this->east),
                new Coordinates($this->south, $this->west),
                $northWest,
            ]),
        );
    }

    #[Override]
    public function setPolygon(PolygonInterface $polygon): void
    {
        foreach ($polygon->getCoordinates() as $coordinate) {
            $this->addCoordinate($coordinate);
        }
    }

    #[Override]
    public function merge(BoundsInterface $bounds): self
    {
        $cBounds = clone $this;

        $newCoordinates = $bounds->getAsPolygon()->getCoordinates();
        foreach ($newCoordinates as $coordinate) {
            $cBounds->addCoordinate($coordinate);
        }

        return $cBounds;
    }

    /**
     * Returns an array with bounds.
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'south' => $this->getSouth(),
            'west' => $this->getWest(),
            'north' => $this->getNorth(),
            'east' => $this->getEast(),
        ];
    }

    protected function addCoordinate(CoordinatesInterface $coordinate)
    {
        $latitude = $coordinate->getLatitude();
        $longitude = $coordinate->getLongitude();

        if (!$this->north && !$this->south && !$this->east && !$this->west) {
            $this->setNorth($latitude);
            $this->setSouth($latitude);
            $this->setEast($longitude);
            $this->setWest($longitude);
        } else {
            if (bccomp(
                number_format($latitude, $this->getPrecision()),
                number_format($this->getSouth(), $this->getPrecision()),
                $this->getPrecision()) === -1
            ) {
                $this->setSouth($latitude);
            }

            if (bccomp(
                number_format($latitude, $this->getPrecision()),
                number_format($this->getNorth(), $this->getPrecision()),
                $this->getPrecision()) === 1
            ) {
                $this->setNorth($latitude);
            }

            if (bccomp(
                number_format($longitude, $this->getPrecision()),
                number_format($this->getEast(), $this->getPrecision()),
                $this->getPrecision()) === 1
            ) {
                $this->setEast($longitude);
            }

            if (bccomp(
                number_format($longitude, $this->getPrecision()),
                number_format($this->getWest(), $this->getPrecision()),
                $this->getPrecision()) === -1
            ) {
                $this->setWest($longitude);
            }
        }
    }
}
