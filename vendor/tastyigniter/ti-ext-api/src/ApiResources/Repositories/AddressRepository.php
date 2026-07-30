<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\User\Models\Address;

class AddressRepository extends AbstractRepository
{
    protected ?string $modelClass = Address::class;

    protected static $customerAwareConfig = ['column' => 'customer_id'];
}
