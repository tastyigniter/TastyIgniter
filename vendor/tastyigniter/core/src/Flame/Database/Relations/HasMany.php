<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany as HasManyBase;

/**
 * Adapted from october\rain\database\relations\HasMany
 * @property \Igniter\Flame\Database\Model $parent
 */
class HasMany extends HasManyBase
{
    use DefinedConstraints;
    use HasOneOrMany;

    /**
     * Create a new has many relationship instance.
     */
    public function __construct(Builder $query, Model $parent, $foreignKey, $localKey, $relationName = null)
    {
        $this->relationName = $relationName;

        parent::__construct($query, $parent, $foreignKey, $localKey);

        $this->addDefinedConstraints();
    }

    /**
     * Helper for setting this relationship using various expected
     * values. For example, $model->relation = $value;
     */
    public function setSimpleValue($value): void
    {
        // Nulling the relationship
        if (!$value) {
            $this->parent->unsetRelation($this->relationName);

            if ($this->parent->exists) {
                $this->parent->bindEventOnce('model.afterSave', function() {
                    $this->ensureRelationIsEmpty();
                });
            }

            return;
        }

        if ($value instanceof Model) {
            $value = new Collection([$value]);
        }

        if ($value instanceof Collection) {
            $collection = $value;

            if ($this->parent->exists) {
                $collection->each(function($instance) {
                    $instance->setAttribute($this->getForeignKeyName(), $this->getParentKey());
                });
            }
        } else {
            $collection = $this->getRelated()->whereIn($this->getRelatedKeyName(), (array)$value)->get();
        }

        if ($collection) {
            $this->parent->setRelation($this->relationName, $collection);

            $this->parent->bindEventOnce('model.afterSave', function() use ($collection) {
                $existingIds = $collection->pluck($this->getRelatedKeyName())->all();

                $this->whereNotIn($this->getRelatedKeyName(), $existingIds)->update([
                    $this->getForeignKeyName() => null,
                ]);

                $collection->each(function($instance) {
                    $instance->setAttribute($this->getForeignKeyName(), $this->getParentKey());
                    $instance->save(['timestamps' => false]);
                });
            });
        }
    }

    /**
     * Helper for getting this relationship simple value,
     * generally useful with form values.
     */
    public function getSimpleValue()
    {
        $relationName = $this->relationName;

        if ($this->parent->relationLoaded($relationName)) {
            $value = $this->parent->getRelation($relationName)->pluck($this->getRelatedKeyName())->all();
        } else {
            $value = $this->query->getQuery()->pluck($this->getRelatedKeyName())->all();
        }

        return $value;
    }
}
