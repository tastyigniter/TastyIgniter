<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

interface GeoQueryInterface
{
    public function withLocale(string $locale): self;

    public function withLimit(int $limit): self;

    public function withData(string $name, mixed $value): self;

    public function getText(): string;

    public function getBounds(): ?BoundsInterface;

    public function getLocale(): ?string;

    public function getLimit(): int;

    public function getData(string $name, mixed $default = null): mixed;

    public function getAllData(): array;

    public function getCoordinates(): ?CoordinatesInterface;

    public function __toString(): string;
}
