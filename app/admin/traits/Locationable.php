<?php

namespace Admin\Traits;

use Admin;
use Admin\Classes\LocationScope;
use Igniter\Flame\Database\Model;

trait Locationable
{
    /*
     * You can change the location relation name:
     *
     * const LOCATIONABLE_RELATION = 'location';
     */

    /**
     * @var bool Flag for arbitrarily enabling location scope.
     */
    public $locationScopeEnabled;

    /**
     * Boot the locationable trait for a model.
     *
     * @return void
     */
    public static function bootLocationable()
    {
        static::saving(function (Model $model) {
            $model->syncLocationsOnSave();
        });

        static::deleting(function (Model $model) {
            $model->detachLocationsOnDelete();
        });

        static::addGlobalScope(new LocationScope);
    }

    protected function syncLocationsOnSave()
    {
        if ($this->locationableIsSingleRelationType())
            return;

        $relationName = $this->locationableRelationName();
        $locationsToSync = $this->$relationName;
        unset($this->$relationName);

        if (is_null($locationsToSync))
            return;

        $this->getLocationableRelationObject()->sync($locationsToSync);
    }

    protected function detachLocationsOnDelete()
    {
        if ($this->locationableIsSingleRelationType())
            return;

        $this->getLocationableRelationObject()->detach();
    }

    public function scopeHasLocation($query, $locationId)
    {
        return $this->applyLocationScope($query, $locationId);
    }

    /**
     * Apply the Location scope query.
     *
     * @param \Igniter\Flame\Database\Builder $builder
     * @param \Igniter\Flame\Auth\Models\User $userLocation
     */
    public function applyLocationScope($builder, $userLocation)
    {
        $locationId = !is_numeric($userLocation)
            ? $userLocation->getKey() : $userLocation;

        $relationName = $this->locationableRelationName();

        $relationObject = $this->getLocationableRelationObject();
        $locationModel = $relationObject->getRelated();

        if ($this->locationableIsSingleRelationType()) {
            $builder->where($locationModel->getKeyName(), $locationId);
        }
        else {
            $qualifiedColumnName = $relationObject->getTable().'.'.$locationModel->getKeyName();
            $builder->whereHas($relationName, function ($query) use ($qualifiedColumnName, $locationId) {
                $query->where($qualifiedColumnName, $locationId);
            });
        }
    }

    protected function getLocationableRelationObject()
    {
        $relationName = $this->locationableRelationName();

        return $this->{$relationName}();
    }

    protected function locationableIsSingleRelationType()
    {
        $relationType = $this->getRelationType($this->locationableRelationName());

        return in_array($relationType, ['hasOne', 'belongsTo']);
    }

    protected function locationableRelationName()
    {
        return defined('static::LOCATIONABLE_RELATION') ? static::LOCATIONABLE_RELATION : 'location';
    }
}