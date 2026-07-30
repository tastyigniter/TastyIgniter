<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\User\Models\Customer;

class CustomerRepository extends AbstractRepository
{
    protected ?string $modelClass = Customer::class;

    protected static $customerAwareConfig = [];
}
