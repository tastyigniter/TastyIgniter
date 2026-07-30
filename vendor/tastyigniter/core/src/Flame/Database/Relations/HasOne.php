<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne as HasOneBase;

/**
 * Adapted from october\rain\database\relations\HasOne
 * @property \Igniter\Flame\Database\Model $parent
 */
class HasOne extends HasOneBase
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
        if (is_array($value)) {
            $value = current($value);
        }

        // Nulling the relationship
        if (!$value) {
            $this->parent->setRelation($this->relationName, null);

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
                if ($instance->getOriginal($this->getForeignKeyName()) == $this->getParentKey()) {
                    return;
                }

                $this->update([$this->getForeignKeyName() => null]);
                $instance->setAttribute($this->getForeignKeyName(), $this->getParentKey());
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

        if ($related = $this->parent->{$relationName}) {
            $key = $this->getRelatedKeyName();
            $value = $related->{$key};
        }

        return $value;
    }
}
