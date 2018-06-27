<?php

namespace Admin\Classes;

use Admin;
use AdminAuth;
use App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LocationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!App::runningInAdmin())
            return;

        if (!$model->locationScopeEnabled AND !AdminAuth::isStrictLocation())
            return;

        $userLocation = AdminAuth::location();

        $model->applyLocationScope($builder, $userLocation);
    }
}