<?php

declare(strict_types=1);

namespace App\Services;

use Igniter\Local\Models\Location;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class LocationContext
{
    public const SESSION_KEY = 'active_location_id';

    public const GLOBAL_SESSION_KEY = 'active_location_global';

    protected mixed $user = null;

    public function forUser(mixed $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function user(): mixed
    {
        return $this->user ?? app('admin.auth')->user();
    }

    public function authorizedLocations(): Collection
    {
        $user = $this->user();
        if (! $user) {
            return new Collection;
        }

        if ($user->isSuperUser()) {
            return Location::query()->get();
        }

        return $user->locations()->get();
    }

    public function current(): ?Location
    {
        if ($this->isGlobal() || ! $id = $this->rawCurrentId()) {
            return null;
        }

        $location = $this->authorizedLocations()->firstWhere('location_id', $id);
        if (! $location || (! $location->location_status && ! $this->mayAccessInactive())) {
            $this->clear();

            return null;
        }

        return $location;
    }

    public function currentId(): ?int
    {
        return $this->current()?->getKey();
    }

    public function canAccess(int|string|null $locationId): bool
    {
        if (! filter_var($locationId, FILTER_VALIDATE_INT)) {
            return false;
        }

        $location = $this->authorizedLocations()->firstWhere('location_id', (int) $locationId);

        return (bool) $location && ($location->location_status || $this->mayAccessInactive());
    }

    public function set(int|string $locationId): Location
    {
        if (! $this->canAccess($locationId)) {
            Log::warning('Unauthorized location switch attempt', $this->logContext(['requested_location_id' => (int) $locationId]));
            throw new AuthorizationException('You are not authorized to access that location.');
        }

        $oldId = $this->currentId();
        session()->put(self::SESSION_KEY, (int) $locationId);
        session()->forget(self::GLOBAL_SESSION_KEY);
        $location = $this->current();
        Log::info($oldId && $oldId !== (int) $locationId ? 'Location switched' : 'Location selected',
            $this->logContext(['from_location_id' => $oldId, 'location_id' => (int) $locationId]));

        return $location;
    }

    public function setGlobal(): void
    {
        if (! $this->mayViewAll()) {
            Log::warning('Unauthorized global location mode attempt', $this->logContext());
            throw new AuthorizationException('All-locations mode is not permitted.');
        }

        session()->forget(self::SESSION_KEY);
        session()->put(self::GLOBAL_SESSION_KEY, true);
        Log::info('Global location mode entered', $this->logContext());
    }

    public function clear(): void
    {
        $wasGlobal = (bool) session()->get(self::GLOBAL_SESSION_KEY, false);
        session()->forget([self::SESSION_KEY, self::GLOBAL_SESSION_KEY]);
        if ($wasGlobal) {
            Log::info('Global location mode exited', $this->logContext());
        }
    }

    public function isGlobal(): bool
    {
        if (! session()->get(self::GLOBAL_SESSION_KEY, false)) {
            return false;
        }

        if (! $this->mayViewAll()) {
            $this->clear();

            return false;
        }

        return true;
    }

    public function requireCurrent(): Location
    {
        return $this->current() ?? throw new RuntimeException('An active operational location is required.');
    }

    public function scopeQuery(Builder|\Illuminate\Database\Query\Builder $query, string $locationColumn = 'location_id'): mixed
    {
        if ($this->isGlobal()) {
            return $query;
        }

        return $query->where($locationColumn, $this->requireCurrent()->getKey());
    }

    protected function rawCurrentId(): ?int
    {
        $value = session()->get(self::SESSION_KEY);

        return filter_var($value, FILTER_VALIDATE_INT) ? (int) $value : null;
    }

    protected function mayViewAll(): bool
    {
        return (bool) $this->user()?->hasPermission('Restaurant.LocationContext.ViewAll');
    }

    protected function mayAccessInactive(): bool
    {
        return (bool) $this->user()?->hasPermission('Admin.Locations');
    }

    protected function logContext(array $context = []): array
    {
        return $context + ['user_id' => $this->user()?->getAuthIdentifier()];
    }
}
