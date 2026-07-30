<?php

declare(strict_types=1);

namespace Igniter\Coupons\ApiResources\Transformers;

use Igniter\Api\ApiResources\Transformers\CategoryTransformer;
use Igniter\Api\ApiResources\Transformers\MenuTransformer;
use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Coupons\Models\Coupon;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class CouponsTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    protected array $availableIncludes = [
        'menus',
        'categories',
        'history',
    ];

    public function transform(Coupon $coupon): array
    {
        return $this->mergesIdAttribute($coupon);
    }

    public function includeCategories(Coupon $coupon): Collection
    {
        return $this->collection(
            $coupon->categories,
            new CategoryTransformer,
            'categories',
        );
    }

    public function includeMenus(Coupon $coupon): Collection
    {
        return $this->collection(
            $coupon->menus,
            new MenuTransformer,
            'menus',
        );
    }

    public function includeHistory(Coupon $coupon): Collection
    {
        return $this->collection(
            $coupon->history,
            new CouponHistoryTransformer,
            'history',
        );
    }
}
