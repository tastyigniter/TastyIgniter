<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne as MorphOneBase;

/**
 * Adapted from october\rain\database\relations\MorphOne
 * @property \Igniter\Flame\Database\Model $parent
 */
class MorphOne extends MorphOneBase
{
    use DefinedConstraints;
    use MorphOneOrMany;

    /**
     * Create a new has many relationship instance.
     */
    public function __construct(Builder $query, Model $parent, $type, $id, $localKey, $relationName = null)
    {
        $this->relationName = $relationName;

        parent::__construct($query, $parent, $type, $id, $localKey);

        $this->addDefinedConstraints();
    }

    /**
     * Helper for setting this relationship using various expected
     * values. For example, $model->relation = $value;
     */
    public function setSimpleValue($value): void
    {
        if (is_array($value)) {
            $value = current($value);
        }

        // Nulling the relationship
        if (!$value) {
            if ($this->parent->exists) {
                $this->parent->bindEventOnce('model.afterSave', function() {
                    $this->ensureRelationIsEmpty();
                });
            }

            return;
        }

        if ($value instanceof Model) {
            $instance = $value;

            if ($this->parent->exists) {
                $instance->setAttribute($this->getForeignKeyName(), $this->getParentKey());
                $instance->setAttribute($this->getMorphType(), $this->morphClass);
            }
        } else {
            $instance = $this->getRelated()->find($value);
        }

        if ($instance) {
            $this->parent->setRelation($this->relationName, $instance);

            $this->parent->bindEventOnce('model.afterSave', function() use ($instance) {
                // Relation is already set, do nothing. This prevents the relationship
                // from being nulled below and left unset because the save will ignore
                // attribute values that are numerically equivalent (not dirty).
                if (
                    $instance->getOriginal($this->getForeignKeyName()) == $this->getParentKey() &&
                    $instance->getOriginal($this->getMorphType()) == $this->morphClass
                ) {
                    return;
                }

                $this->update([
                    $this->getForeignKeyName() => null,
                    $this->getMorphType() => null,
                ]);
                $instance->setAttribute($this->getForeignKeyName(), $this->getParentKey());
                $instance->setAttribute($this->getMorphType(), $this->morphClass);
                $instance->save(['timestamps' => false]);
            });
        }
    }

    /**
     * Helper for getting this relationship simple value,
     * generally useful with form values.
     */
    public function getSimpleValue()
    {
        $value = null;
        $relationName = $this->relationName;

        if ($related = $this->parent->$relationName) {
            $key = $this->getRelatedKeyName();
            $value = $related->$key;
        }

        return $value;
    }
}
