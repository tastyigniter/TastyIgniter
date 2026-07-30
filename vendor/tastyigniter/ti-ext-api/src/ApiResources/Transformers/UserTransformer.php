<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\User\Models\User;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    protected array $availableIncludes = [
        'groups',
        'locations',
        'role',
        'language',
    ];

    public function transform(User $user): array
    {
        return $this->mergesIdAttribute($user);
    }

    public function includeGroups(User $user): ?Collection
    {
        return $this->collection(
            $user->groups,
            new UserGroupTransformer,
            'groups'
        );
    }

    public function includeLocations(User $user): ?Collection
    {
        return $this->collection(
            $user->locations,
            new LocationTransformer,
            'locations'
        );
    }

    public function includeRole(User $user): ?Item
    {
        return $this->item(
            $user->role,
            new UserRoleTransformer,
            'role'
        );
    }
}
