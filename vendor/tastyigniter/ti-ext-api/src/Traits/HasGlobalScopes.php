<?php

declare(strict_types=1);

namespace Igniter\Api\Traits;

use Closure;
use Illuminate\Database\Eloquent\Scope;
use InvalidArgumentException;

trait HasGlobalScopes
{
    protected $scopes = [];

    public function addGlobalScope($scope, ?Closure $implementation = null): Closure|Scope
    {
        if (is_string($scope) && !is_null($implementation)) {
            return $this->scopes[static::class][$scope] = $implementation;
        } elseif ($scope instanceof Closure) {
            return $this->scopes[static::class][spl_object_hash($scope)] = $scope;
        } elseif ($scope instanceof Scope) {
            return $this->scopes[static::class][$scope::class] = $scope;
        }

        throw new InvalidArgumentException('Global scope must be an instance of Closure or Scope.');
    }

    protected function applyScopes($query)
    {
        foreach ($this->scopes as $identifier => $scope) {
            $query->withGlobalScope($identifier, $scope);
        }
    }
}
