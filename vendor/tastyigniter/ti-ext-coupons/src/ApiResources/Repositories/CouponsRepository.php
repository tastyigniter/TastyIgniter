<?php

declare(strict_types=1);

namespace Igniter\Coupons\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Coupons\Models\Coupon;

class CouponsRepository extends AbstractRepository
{
    protected ?string $modelClass = Coupon::class;
}
