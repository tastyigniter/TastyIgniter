<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Cart\Models\Menu;
use Illuminate\Database\Eloquent\Builder;

class MenuRepository extends AbstractRepository
{
    protected ?string $modelClass = Menu::class;

    protected static $locationAwareConfig = [];

    protected function extendQuery(Builder $query): void
    {
        $query->with(['menu_options.menu_option_values']);
    }
}
