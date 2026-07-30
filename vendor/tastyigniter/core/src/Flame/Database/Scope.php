<?php

declare(strict_types=1);

namespace Igniter\Flame\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope as IlluminateScope;
use Override;

abstract class Scope implements IlluminateScope
{
    protected array $extensions = [];

    #[Override]
    public function apply(Builder $builder, Model $model) {}

    public function extend(Builder $builder): void
    {
        foreach (get_class_methods($this) as $extension) {
            if (starts_with($extension, 'add')) {
                $marcoName = camel_case(str_after($extension, 'add'));
                $builder->macro($marcoName, $this->{$extension}());
            }
        }
    }
}
