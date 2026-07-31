<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Services;

use Naxas\RestaurantOps\Contracts\LocationContextContract;

final class OperationalAccessService
{
    public function __construct(private readonly LocationContextContract $context) {}

    public function denial(mixed $user, string $permission, bool $transactional = false): ?array
    {
        if (! $user || ! $user->status) {
            return ['operational_staff_inactive', 'An active staff account is required.', 403];
        }

        if (! $user->hasPermission($permission)) {
            return ['operational_permission_denied', 'You are not authorized to access this operational feature.', 403];
        }

        if ($transactional && $this->context->isGlobal()) {
            return ['operational_global_mode_not_allowed', 'Select a concrete branch for transactional operations.', 409];
        }

        if ($transactional && ! $this->context->isGlobal() && ! $this->context->current()) {
            return ['operational_location_required', 'Select an active assigned location to continue.', 409];
        }

        return null;
    }

    public function resourceMatches(int|string|null $locationId): bool
    {
        return ! $this->context->isGlobal() && $this->context->currentId() === (int) $locationId;
    }
}
