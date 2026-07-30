<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite;

use Igniter\Flame\Geolite\Contracts\BoundsInterface;
use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\GeocoderInterface;
use Igniter\Flame\Geolite\Contracts\GeoQueryInterface;
use Igniter\Flame\Geolite\Model\Bounds;
use Igniter\Flame\Geolite\Model\Coordinates;
use InvalidArgumentException;
use Override;

class GeoQuery implements GeoQueryInterface
{
    /**
     * The address or text that should be geocoded.
     */
    protected ?string $text = null;

    protected ?CoordinatesInterface $coordinates = null;

    protected ?BoundsInterface $bounds = null;

    protected ?string $locale = null;

    protected int $limit = GeocoderInterface::DEFAULT_RESULT_LIMIT;

    protected array $data = [];

    public function __construct(string|Coordinates $text)
    {
        if ($text instanceof Coordinates) {
            $this->coordinates = $text;
        } elseif (!empty($text)) {
            $this->text = $text;
        } elseif ($text === '') {
            throw new InvalidArgumentException('Geocode query cannot be empty');
        }
    }

    public static function create(string $text): self
    {
        return new self($text);
    }

    public function withBounds(Bounds $bounds): self
    {
        $this->bounds = $bounds;

        return $this;
    }

    #[Override]
    public function withLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    #[Override]
    public function withLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    #[Override]
    public function withData(string $name, $value): GeoQueryInterface
    {
        $this->data[$name] = $value;

        return $this;
    }

    #[Override]
    public function getText(): string
    {
        return $this->text;
    }

    #[Override]
    public function getBounds(): ?BoundsInterface
    {
        return $this->bounds;
    }

    #[Override]
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    #[Override]
    public function getLimit(): int
    {
        return $this->limit;
    }

    #[Override]
    public function getData(string $name, mixed $default = null): mixed
    {
        if (!array_key_exists($name, $this->data)) {
            return $default;
        }

        return $this->data[$name];
    }

    #[Override]
    public function getAllData(): array
    {
        return $this->data;
    }

    //
    //
    //

    public static function fromCoordinates(int|float $latitude, int|float $longitude): self
    {
        return new self(new Coordinates($latitude, $longitude));
    }

    public function withCoordinates(Coordinates $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    #[Override]
    public function getCoordinates(): ?CoordinatesInterface
    {
        return $this->coordinates;
    }

    /**
     * String for logging. This is also a unique key for the query
     */
    #[Override]
    public function __toString(): string
    {
        return sprintf('GeoQuery: %s', json_encode([
            'text' => $this->getText(),
            'bounds' => !is_null($this->getBounds()) ? $this->getBounds()->toArray() : 'null',
            'coordinates' => $this->getCoordinates()?->toArray() ?? 'null',
            'locale' => $this->getLocale(),
            'limit' => $this->getLimit(),
            'data' => $this->getAllData(),
        ]));
    }
}
