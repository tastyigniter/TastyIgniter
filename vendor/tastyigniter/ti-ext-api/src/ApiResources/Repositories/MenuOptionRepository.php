<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Cart\Models\MenuOption;

class MenuOptionRepository extends AbstractRepository
{
    protected ?string $modelClass = MenuOption::class;

    protected static $locationAwareConfig = [];
}
