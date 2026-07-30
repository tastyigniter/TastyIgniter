<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\User\Models\UserRole;
use League\Fractal\TransformerAbstract;

class UserRoleTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(UserRole $userRole): array
    {
        return $this->mergesIdAttribute($userRole);
    }
}
