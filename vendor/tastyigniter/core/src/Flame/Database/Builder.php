<?php

declare(strict_types=1);

namespace Igniter\Flame\Database;

use Igniter\Flame\Database\Concerns\ExtendsEloquentBuilder;
use Illuminate\Database\Eloquent\Builder as BuilderBase;

/**
 * TastyIgniter Database Manager Class
 */
class Builder extends BuilderBase
{
    use ExtendsEloquentBuilder;
}
