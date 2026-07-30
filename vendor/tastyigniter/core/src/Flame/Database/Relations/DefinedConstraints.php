<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyBase;

/*
 * Handles the constraints and filters defined by a relation.
 * eg: 'conditions' => 'is_published = 1'
 *
 * Adapted from october\rain\database\relations\DefinedConstraints
 */

trait DefinedConstraints
{
    /**
     * Set the defined constraints on the relation query.
     */
    public function addDefinedConstraints(): void
    {
        $args = $this->parent->getRelationDefinition($this->relationName);

        $this->addDefinedConstraintsToRelation($this, $args);

        $this->addDefinedConstraintsToQuery($this, $args);
    }

    /**
     * Add relation based constraints.
     *
     * @param static $relation
     * @param array $args
     */
    public function addDefinedConstraintsToRelation($relation, $args = null): void
    {
        if ($args === null) {
            $args = $this->parent->getRelationDefinition($this->relationName);
        }

        // Default models (belongsTo)
        if ($defaultData = array_get($args, 'default')) {
            $relation->withDefault($defaultData);
        }

        // Pivot data (belongsToMany, morphToMany, morphByMany)
        if ($pivotData = array_get($args, 'pivot')) {
            $relation->withPivot($pivotData);
        }

        // Pivot incrementing key (belongsToMany, morphToMany, morphByMany)
        if ($pivotKey = array_get($args, 'pivotKey')) {
            $relation->withPivot($pivotKey);
        }

        // Pivot timestamps (belongsToMany, morphToMany, morphByMany)
        if (array_get($args, 'timestamps')) {
            $relation->withTimestamps();
        }

        // Count "helper" relation
        if (array_get($args, 'count')) {
            if ($relation instanceof BelongsToManyBase) {
                $relation->countMode = true;
                $keyName = $relation->getQualifiedForeignPivotKeyName();
            } else {
                $keyName = $relation->getForeignKeyName();
            }

            $countSql = $this->parent->getConnection()->raw('count(*) as count');

            $relation->select($relation->getForeignKey(), $countSql)->groupBy($keyName)->orderBy($keyName);
        }
    }

    /**
     * Add query based constraints.
     *
     * @param static $query
     * @param array $args
     */
    public function addDefinedConstraintsToQuery($query, $args = null): void
    {
        if ($args === null) {
            $args = $this->parent->getRelationDefinition($this->relationName);
        }

        // Conditions
        if ($conditions = array_get($args, 'conditions')) {
            $query->whereRaw($conditions);
        }

        // Sort order
        $hasCountArg = array_get($args, 'count') !== null;
        if (($orderBy = array_get($args, 'order')) && !$hasCountArg) {
            if (!is_array($orderBy)) {
                $orderBy = [$orderBy];
            }

            foreach ($orderBy as $order) {
                $column = $order;
                $direction = 'asc';

                $parts = explode(' ', (string)$order);
                if (count($parts) > 1) {
                    [$column, $direction] = $parts;
                }

                $query->orderBy($column, $direction);
            }
        }

        // Scope
        if ($scope = array_get($args, 'scope')) {
            if (is_string($scope)) {
                $query->$scope($this->parent);
            } else {
                $scope($query, $this->parent, $this->related);
            }
        }
    }
}
