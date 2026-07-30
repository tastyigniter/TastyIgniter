<?php

declare(strict_types=1);

namespace Igniter\Coupons\Models\Scopes;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Scope;

class CouponScope extends Scope
{
    public function addIsAutoApplicable()
    {
        return fn(Builder $builder) => $builder->where('auto_apply', '1');
    }

    public function addWhereHasCategory()
    {
        return fn(Builder $builder, $categoryId) => $builder->whereHas('categories', function($q) use ($categoryId): void {
            $q->where('categories.category_id', $categoryId);
        });
    }

    public function addWhereHasMenu()
    {
        return fn(Builder $builder, $menuId) => $builder->whereHas('menus', function($q) use ($menuId): void {
            $q->where('menus.menu_id', $menuId);
        });
    }

    public function addWhereCodeAndLocation()
    {
        return fn(Builder $builder, $code, $locationId) => $builder->whereHasOrDoesntHaveLocation($locationId)->whereCode($code);
    }
}
