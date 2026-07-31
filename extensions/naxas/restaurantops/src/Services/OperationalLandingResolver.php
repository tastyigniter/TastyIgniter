<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Services;

use Naxas\RestaurantOps\Contracts\LocationContextContract;

final class OperationalLandingResolver
{
    public function __construct(private readonly RoleProfileResolver $profiles, private readonly LocationContextContract $context) {}

    public function routeName(mixed $user): ?string
    {
        return match ($this->profiles->resolve($user)) {
            'owner' => $this->context->isGlobal() && $user->hasPermission('Restaurant.Operations.HeadOfficeDashboard')
                ? 'naxas.restaurantops.head-office' : 'naxas.restaurantops.branch-operations',
            'branch_manager' => 'naxas.restaurantops.branch-operations',
            'cashier' => 'naxas.restaurantops.cashier',
            'waiter' => 'naxas.restaurantops.waiter',
            'kitchen' => 'naxas.restaurantops.kitchen',
            default => null,
        };
    }
}
