<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Cart\Models\Order;

class OrderRepository extends AbstractRepository
{
    protected ?string $modelClass = Order::class;

    protected static $locationAwareConfig = [];

    protected static $customerAwareConfig = [];
}
