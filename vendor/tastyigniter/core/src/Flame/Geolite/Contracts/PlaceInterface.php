<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

interface PlaceInterface
{
    public function placeId(string $placeId): self;

    public function title(string $title): self;

    public function description(string $description): self;

    public function provider(string $provider): self;

    public function getPlaceId(): string;

    public function getTitle(): string;

    public function getDescription(): string;

    public function getProvider(): string;

    public function withData(string $name, mixed $value): self;

    public function getData(string $name, mixed $default = null): mixed;
}
