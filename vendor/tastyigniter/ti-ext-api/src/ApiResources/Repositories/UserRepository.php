<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\User\Models\User;

class UserRepository extends AbstractRepository
{
    protected ?string $modelClass = User::class;

    protected static $locationAwareConfig = [];
}
