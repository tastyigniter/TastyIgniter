<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Services;

use Naxas\RestaurantOps\Support\RoleProfiles;

final class RoleProfileResolver
{
    public function resolve(mixed $user): ?string
    {
        $code = $user?->role?->code;
        foreach (RoleProfiles::PROFILES as $profile => $definition) {
            if ($code === $definition['code']) {
                return $profile;
            }
        }

        return null;
    }
}
