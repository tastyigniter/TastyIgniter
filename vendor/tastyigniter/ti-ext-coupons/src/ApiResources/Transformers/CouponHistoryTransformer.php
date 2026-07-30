<?php

declare(strict_types=1);

namespace Igniter\Coupons\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Coupons\Models\CouponHistory;
use League\Fractal\TransformerAbstract;

class CouponHistoryTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(CouponHistory $history): array
    {
        return $this->mergesIdAttribute($history);
    }
}
