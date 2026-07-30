<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\NestedSet;

use Igniter\Flame\Database\Concerns\ExtendsEloquentBuilder;
use Kalnoy\Nestedset\QueryBuilder as QueryBuilderBase;

class QueryBuilder extends QueryBuilderBase
{
    use ExtendsEloquentBuilder;
}
