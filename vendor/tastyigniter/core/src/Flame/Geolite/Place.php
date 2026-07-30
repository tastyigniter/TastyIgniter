<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite;

use Igniter\Flame\Geolite\Contracts\PlaceInterface;
use Illuminate\Contracts\Support\Arrayable;
use Override;

class Place implements Arrayable, PlaceInterface
{
    protected ?string $placeId = null;

    protected ?string $title = null;

    protected ?string $description = null;

    protected ?string $provider = null;

    protected array $data = [];

    #[Override]
    public function placeId(string $placeId): PlaceInterface
    {
        $this->placeId = $placeId;

        return $this;
    }

    #[Override]
    public function title(string $title): PlaceInterface
    {
        $this->title = $title;

        return $this;
    }

    #[Override]
    public function description(string $description): PlaceInterface
    {
        $this->description = $description;

        return $this;
    }

    #[Override]
    public function provider(string $provider): PlaceInterface
    {
        $this->provider = $provider;

        return $this;
    }

    #[Override]
    public function withData(string $name, mixed $value): self
    {
        $this->data[$name] = $value;

        return $this;
    }

    #[Override]
    public function getPlaceId(): string
    {
        return $this->placeId;
    }

    #[Override]
    public function getTitle(): string
    {
        return $this->title;
    }

    #[Override]
    public function getDescription(): string
    {
        return $this->description;
    }

    #[Override]
    public function getProvider(): string
    {
        return $this->provider;
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
    public function toArray(): array
    {
        return [
            'placeId' => $this->getPlaceId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'provider' => $this->getProvider(),
            'data' => $this->data,
        ];
    }
}
