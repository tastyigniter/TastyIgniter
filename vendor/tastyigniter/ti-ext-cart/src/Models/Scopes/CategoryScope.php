<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Scopes;

use Igniter\Flame\Database\Scope;
use Illuminate\Database\Eloquent\Builder;

class CategoryScope extends Scope
{
    public function addWhereHasMenus()
    {
        return fn(Builder $builder) => $builder->whereHas('menus')->where('status', 1);
    }
}
