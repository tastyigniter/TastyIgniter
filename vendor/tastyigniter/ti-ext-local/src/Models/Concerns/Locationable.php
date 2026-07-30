<?php

declare(strict_types=1);

namespace Igniter\Local\Models\Concerns;

use Igniter\Flame\Exception\FlashException;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Local\Models\Scopes\LocationableScope;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Support\Collection;

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
    public $locationScopeEnabled = false;

    /**
     * Boot the locationable trait for a model.
     */
    public static function bootLocationable(): void
    {
        static::addGlobalScope(new LocationableScope);

        static::deleting(function(self $model): void {
            $model->detachLocationsOnDelete();
        });
    }

    //
    //
    //

    protected function detachLocationsOnDelete()
    {
        if ($this->locationableIsSingleRelationType() || !$this->locationableIsMorphRelationType()) {
            return;
        }

        $locationable = $this->getLocationableRelationObject();

        if (Igniter::runningInAdmin() && !AdminAuth::isSuperUser() && $locationable->count()) {
            throw new FlashException(lang('igniter::admin.alert_warning_locationable_delete'));
        }

        $locationable->detach();
    }

    //
    //
    //

    public function getLocationableRelationObject()
    {
        $relationName = $this->locationableRelationName();

        return $this->{$relationName}();
    }

    public function locationableIsSingleRelationType(): bool
    {
        $relationType = $this->getRelationType($this->locationableRelationName());

        return in_array($relationType, ['hasOne', 'belongsTo', 'morphOne']);
    }

    public function locationableIsMorphRelationType(): bool
    {
        $relationType = $this->getRelationType($this->locationableRelationName());

        return in_array($relationType, ['morphToMany', 'belongsToMany']);
    }

    public function locationableRelationName()
    {
        return defined('static::LOCATIONABLE_RELATION') ? static::LOCATIONABLE_RELATION : 'location';
    }

    public function locationableRelationExists(): bool
    {
        $relationName = $this->locationableRelationName();

        if ($this->locationableIsSingleRelationType()) {
            return !is_null($this->{$relationName});
        }

        return $this->{$relationName} instanceof Collection ? $this->{$relationName}->isNotEmpty() : ($this->{$relationName} ?? []) !== [];
    }
}
