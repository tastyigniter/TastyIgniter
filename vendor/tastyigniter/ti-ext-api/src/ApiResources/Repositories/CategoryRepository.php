<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Cart\Models\Category;

class CategoryRepository extends AbstractRepository
{
    protected ?string $modelClass = Category::class;

    protected static $locationAwareConfig = [];
}
