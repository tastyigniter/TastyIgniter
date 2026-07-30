<?php

declare(strict_types=1);

namespace Igniter\Flame\Providers;

use Igniter\Flame\Database\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as IlluminateEventServiceProvider;
use Override;

abstract class EventServiceProvider extends IlluminateEventServiceProvider
{
    /**
     * The model query scopes to register.
     * @var array<Model, string|array>
     */
    protected array $scopes = [];

    protected array $morphMap = [];

    #[Override]
    public function register()
    {
        parent::register();

        $this->booting(function() {
            foreach ($this->scopes as $model => $scopes) {
                $model::extend(function($model) use ($scopes) {
                    foreach ((array)$scopes as $scope) {
                        $model::addGlobalScope($scope, new $scope);
                    }
                });
            }

            Relation::enforceMorphMap($this->morphMap);
        });
    }
}
