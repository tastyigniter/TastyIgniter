<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Services;

use InvalidArgumentException;
use Naxas\RestaurantOps\Models\StaffPreference;

final class StaffPreferenceService
{
    public function defaultLocationId(mixed $user): ?int
    {
        $id = StaffPreference::query()->where('staff_id', $user->getKey())->value('default_location_id');
        if (! $id) {
            return null;
        }

        $valid = $user->locations()->whereKey($id)->where('location_status', 1)->exists();

        return $valid ? (int) $id : null;
    }

    public function setDefault(mixed $user, int|string|null $locationId): void
    {
        if ($locationId !== null && (! $locationId || ! $user->locations()->whereKey((int) $locationId)->where('location_status', 1)->exists())) {
            throw new InvalidArgumentException('The default location must be an active assigned location.');
        }

        StaffPreference::query()->updateOrCreate(['staff_id' => $user->getKey()], ['default_location_id' => $locationId ? (int) $locationId : null]);
    }
}
