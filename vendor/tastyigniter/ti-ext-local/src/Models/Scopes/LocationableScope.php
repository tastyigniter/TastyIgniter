<?php

declare(strict_types=1);

namespace Igniter\Local\Models\Scopes;

use Igniter\Flame\Database\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LocationableScope extends Scope
{
    public function addWhereHasLocation()
    {
        return function(Builder $builder, $locationId) {
            $builder->withoutGlobalScope($this);

            $locationId = $locationId instanceof Model
                ? $locationId->getKey()
                : $locationId;

            if (!is_array($locationId)) {
                $locationId = [$locationId];
            }

            $relationName = $builder->getModel()->locationableRelationName();
            $relationObject = $builder->getModel()->getLocationableRelationObject();
            $locationModel = $relationObject->getRelated();

            if ($builder->getModel()->locationableIsSingleRelationType()) {
                return $builder->whereIn($locationModel->getKeyName(), $locationId);
            }

            $qualifiedColumnName = $builder->getModel()->locationableIsMorphRelationType()
                ? $relationObject->getTable().'.'.$locationModel->getKeyName()
                : $relationObject->getParent()->getTable().'.'.$locationModel->getKeyName();

            return $builder->whereHas($relationName, function($query) use ($qualifiedColumnName, $locationId): void {
                $query->whereIn($qualifiedColumnName, $locationId);
            });
        };
    }

    public function addWhereHasOrDoesntHaveLocation()
    {
        return function(Builder $builder, $locationId) {
            $builder->withoutGlobalScope($this);

            return $builder->where(function(Builder $builder) use ($locationId) {
                $builder->whereHasLocation($locationId);

                if ($builder->getModel()->locationableIsSingleRelationType()) {
                    return $builder->orWhereNull($builder->getModel()->getLocationableRelationObject()->getRelated()->getKeyName());
                }

                return $builder->orDoesntHave($builder->getModel()->locationableRelationName());
            });
        };
    }
}
