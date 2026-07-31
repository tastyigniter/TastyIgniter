<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Contracts;

use Igniter\Local\Models\Location;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface LocationContextContract
{
    public function forUser(mixed $user): self;

    public function user(): mixed;

    public function authorizedLocations(): Collection;

    public function current(): ?Location;

    public function currentId(): ?int;

    public function canAccess(int|string|null $locationId): bool;

    public function set(int|string $locationId): Location;

    public function setGlobal(): void;

    public function clear(): void;

    public function isGlobal(): bool;

    public function requireCurrent(): Location;

    public function scopeQuery(Builder|\Illuminate\Database\Query\Builder $query, string $locationColumn = 'location_id'): mixed;
}
