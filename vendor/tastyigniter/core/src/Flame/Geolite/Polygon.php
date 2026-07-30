<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite;

use ArrayAccess;
use Countable;
use Igniter\Flame\Geolite\Contracts\BoundsInterface;
use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\PolygonInterface;
use Igniter\Flame\Geolite\Model\Bounds;
use Igniter\Flame\Geolite\Model\Coordinates;
use Igniter\Flame\Geolite\Model\CoordinatesCollection;
use InvalidArgumentException;
use IteratorAggregate;
use JsonSerializable;
use Override;
use Traversable;

class Polygon implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable, PolygonInterface
{
    public const TYPE = 'POLYGON';

    protected CoordinatesCollection $coordinates;

    protected BoundsInterface $bounds;

    protected bool $hasCoordinate = false;

    protected ?int $precision = 8;

    /**
     * @param null|array|CoordinatesCollection $coordinates
     */
    public function __construct($coordinates = null)
    {
        if ($coordinates instanceof CoordinatesCollection) {
            $this->coordinates = $coordinates;
        } elseif (is_array($coordinates) || is_null($coordinates)) {
            $this->coordinates = new CoordinatesCollection([]);
        } else {
            throw new InvalidArgumentException;
        }

        $this->bounds = Bounds::fromPolygon($this);

        if (is_array($coordinates)) {
            $this->put($coordinates);
        }
    }

    #[Override]
    public function getGeometryType(): string
    {
        return self::TYPE;
    }

    #[Override]
    public function getCoordinate(): ?CoordinatesInterface
    {
        return $this->coordinates->offsetGet(0);
    }

    #[Override]
    public function getCoordinates(): CoordinatesCollection
    {
        return $this->coordinates;
    }

    public function setCoordinates(CoordinatesCollection $coordinates): static
    {
        $this->coordinates = $coordinates;
        $this->bounds->setPolygon($this);

        return $this;
    }

    #[Override]
    public function getPrecision(): ?int
    {
        return $this->precision;
    }

    public function setPrecision(int $precision): self
    {
        $this->bounds->setPrecision($precision);
        $this->precision = $precision;

        return $this;
    }

    #[Override]
    public function getBounds(): BoundsInterface
    {
        return $this->bounds;
    }

    public function setBounds(BoundsInterface $bounds): self
    {
        $this->bounds = $bounds;

        return $this;
    }

    //
    //
    //

    public function get(int $key): ?CoordinatesInterface
    {
        return $this->coordinates->get($key);
    }

    public function put(int|array $key, ?CoordinatesInterface $coordinate = null): void
    {
        if (is_array($key)) {
            $values = $key;
        } elseif ($coordinate instanceof CoordinatesInterface) {
            $values = [$key => $coordinate];
        } else {
            throw new InvalidArgumentException;
        }

        foreach ($values as $index => $value) {
            if (!$value instanceof CoordinatesInterface) {
                [$latitude, $longitude] = $value;
                $value = new Coordinates($latitude, $longitude);
            }

            $this->coordinates->put($index, $value);
        }

        $this->bounds->setPolygon($this);
    }

    public function push(CoordinatesInterface $coordinate)
    {
        $coordinates = $this->coordinates->push($coordinate);

        $this->bounds->setPolygon($this);

        return $coordinates;
    }

    public function forget($key)
    {
        $coordinates = $this->coordinates->forget($key);

        $this->bounds->setPolygon($this);

        return $coordinates;
    }

    #[Override]
    public function pointInPolygon(CoordinatesInterface $coordinate): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        if (!$this->bounds->pointInBounds($coordinate)) {
            return false;
        }

        if ($this->pointOnVertex($coordinate)) {
            return true;
        }

        if ($this->pointOnBoundary($coordinate)) {
            return true;
        }

        return $this->pointOnIntersections($coordinate);
    }

    #[Override]
    public function pointOnBoundary(CoordinatesInterface $coordinate): bool
    {
        $total = $this->count();
        for ($i = 1; $i <= $total; $i++) {
            $currentVertex = $this->get($i - 1);
            $nextVertex = $this->get($i);

            if (is_null($nextVertex)) {
                $nextVertex = $this->get(0);
            }

            // Check if coordinate is on a horizontal boundary
            if (bccomp(
                number_format($currentVertex->getLatitude(), $this->getPrecision()),
                number_format($nextVertex->getLatitude(), $this->getPrecision()),
                $this->getPrecision(),
            ) === 0
                && bccomp(
                    number_format($currentVertex->getLatitude(), $this->getPrecision()),
                    number_format($coordinate->getLatitude(), $this->getPrecision()),
                    $this->getPrecision(),
                ) === 0
                && bccomp(
                    number_format($coordinate->getLongitude(), $this->getPrecision()),
                    number_format(min($currentVertex->getLongitude(), $nextVertex->getLongitude()), $this->getPrecision()),
                    $this->getPrecision(),
                ) === 1
                && bccomp(
                    number_format($coordinate->getLongitude(), $this->getPrecision()),
                    number_format(max($currentVertex->getLongitude(), $nextVertex->getLongitude()), $this->getPrecision()),
                    $this->getPrecision(),
                ) === -1
            ) {
                return true;
            }

            // Check if coordinate is on a boundary
            if (bccomp(
                number_format($coordinate->getLatitude(), $this->getPrecision()),
                number_format(min($currentVertex->getLatitude(), $nextVertex->getLatitude()), $this->getPrecision()),
                $this->getPrecision(),
            ) === 1
                && bccomp(
                    number_format($coordinate->getLatitude(), $this->getPrecision()),
                    number_format(max($currentVertex->getLatitude(), $nextVertex->getLatitude()), $this->getPrecision()),
                    $this->getPrecision(),
                ) <= 0
                && bccomp(
                    number_format($coordinate->getLongitude(), $this->getPrecision()),
                    number_format(max($currentVertex->getLongitude(), $nextVertex->getLongitude()), $this->getPrecision()),
                    $this->getPrecision(),
                ) <= 0
                && bccomp(
                    number_format($currentVertex->getLatitude(), $this->getPrecision()),
                    number_format($nextVertex->getLatitude(), $this->getPrecision()),
                    $this->getPrecision(),
                ) !== 0
            ) {
                $xinters = ($coordinate->getLatitude() - $currentVertex->getLatitude())
                    * ($nextVertex->getLongitude() - $currentVertex->getLongitude())
                    / ($nextVertex->getLatitude() - $currentVertex->getLatitude())
                    + $currentVertex->getLongitude();

                if (bccomp(
                    number_format($xinters, $this->getPrecision()),
                    number_format($coordinate->getLongitude(), $this->getPrecision()),
                    $this->getPrecision(),
                ) === 0
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    #[Override]
    public function pointOnVertex(CoordinatesInterface $coordinate): bool
    {
        foreach ($this->coordinates as $vertexCoordinate) {
            if (bccomp(
                number_format($vertexCoordinate->getLatitude(), $this->getPrecision()),
                number_format($coordinate->getLatitude(), $this->getPrecision()),
                $this->getPrecision(),
            ) === 0 &&
                bccomp(
                    number_format($vertexCoordinate->getLongitude(), $this->getPrecision()),
                    number_format($coordinate->getLongitude(), $this->getPrecision()),
                    $this->getPrecision(),
                ) === 0
            ) {
                return true;
            }
        }

        return false;
    }

    protected function pointOnIntersections(CoordinatesInterface $coordinate): bool
    {
        $total = $this->count();
        $intersections = 0;
        for ($i = 1; $i < $total; $i++) {
            $currentVertex = $this->get($i - 1);
            $nextVertex = $this->get($i);

            if (bccomp(
                number_format($coordinate->getLatitude(), $this->getPrecision()),
                number_format(min($currentVertex->getLatitude(), $nextVertex->getLatitude()), $this->getPrecision()),
                $this->getPrecision(),
            ) === 1
                && bccomp(
                    number_format($coordinate->getLatitude(), $this->getPrecision()),
                    number_format(max($currentVertex->getLatitude(), $nextVertex->getLatitude()), $this->getPrecision()),
                    $this->getPrecision(),
                ) <= 0
                && bccomp(
                    number_format($coordinate->getLongitude(), $this->getPrecision()),
                    number_format(max($currentVertex->getLongitude(), $nextVertex->getLongitude()), $this->getPrecision()),
                    $this->getPrecision(),
                ) <= 0
                && bccomp(
                    number_format($currentVertex->getLatitude(), $this->getPrecision()),
                    number_format($nextVertex->getLatitude(), $this->getPrecision()),
                    $this->getPrecision(),
                ) !== 0
            ) {
                $xinters = ($coordinate->getLatitude() - $currentVertex->getLatitude())
                    * ($nextVertex->getLongitude() - $currentVertex->getLongitude())
                    / ($nextVertex->getLatitude() - $currentVertex->getLatitude())
                    + $currentVertex->getLongitude();

                if (bccomp(
                    number_format($coordinate->getLongitude(), $this->getPrecision()),
                    number_format($xinters, $this->getPrecision()),
                    $this->getPrecision(),
                ) <= 0
                    || bccomp(
                        number_format($currentVertex->getLongitude(), $this->getPrecision()),
                        number_format($nextVertex->getLongitude(), $this->getPrecision()),
                        $this->getPrecision(),
                    ) === 0
                ) {
                    $intersections++;
                }
            }
        }

        return $intersections % 2 !== 0;
    }

    //
    //
    //

    #[Override]
    public function isEmpty(): bool
    {
        return $this->count() < 1;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->coordinates->toArray();
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function jsonSerialize(): mixed
    {
        return $this->coordinates->jsonSerialize();
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function offsetExists(mixed $offset): bool
    {
        return $this->coordinates->offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function offsetGet(mixed $offset): mixed
    {
        return $this->coordinates->offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->coordinates->offsetSet($offset, $value);
        $this->bounds->setPolygon($this);
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function offsetUnset(mixed $offset): void
    {
        $this->coordinates->offsetUnset($offset);
        $this->bounds->setPolygon($this);
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function count(): int
    {
        return $this->coordinates->count();
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function getIterator(): Traversable
    {
        return $this->coordinates->getIterator();
    }
}
