<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsToBase;
use Override;

/**
 * Adapted from october\rain\database\relations\BelongsTo
 * @property Model $child
 */
class BelongsTo extends BelongsToBase
{
    use DefinedConstraints;

    /**
     * @param string $relationName
     */
    public function __construct(Builder $query, Model $child, $foreignKey, $ownerKey, /**
     * @var string The "name" of the relationship.
     */
        protected $relationName)
    {
        parent::__construct($query, $child, $foreignKey, $ownerKey, $this->relationName);

        $this->addDefinedConstraints();
    }

    /**
     * create a new instance of this related model with deferred binding support
     */
    public function create(array $attributes = [])
    {
        $model = parent::create($attributes);

        $this->add($model);

        return $model;
    }

    /**
     * Adds a model to this relationship type.
     */
    public function add(Model $model)
    {
        return $this->associate($model);
    }

    /**
     * Removes a model from this relationship type.
     */
    public function remove(Model $model)
    {
        return $this->dissociate();
    }

    /**
     * Override associate() method of BelongsTo relation.
     * This is necessary in order to fire 'model.relation.beforeAssociate', 'model.relation.associate' events
     */
    #[Override]
    public function associate($model)
    {
        if ($this->parent->fireEvent('model.relation.beforeAssociate', [$this->relationName, $model], true) === false) {
            return null;
        }

        $result = parent::associate($model);

        $this->parent->fireEvent('model.relation.associate', [$this->relationName, $model]);

        return $result;
    }

    /**
     * Override dissociate() method of BelongsTo relation.
     * This is necessary in order to fire 'model.relation.beforeDissociate', 'model.relation.dissociate' events
     */
    #[Override]
    public function dissociate()
    {
        if ($this->parent->fireEvent('model.relation.beforeDissociate', [$this->relationName], true) === false) {
            return null;
        }

        $result = parent::dissociate();

        $this->parent->fireEvent('model.relation.dissociate', [$this->relationName]);

        return $result;
    }

    /**
     * Helper for setting this relationship using various expected
     * values. For example, $model->relation = $value;
     */
    public function setSimpleValue($value): void
    {
        // Nulling the relationship
        if (!$value) {
            $this->dissociate();

            return;
        }

        if ($value instanceof Model) {
            // Non-existent model, use a single serve event to associate it again when ready
            if (!$value->exists) {
                $value->bindEventOnce('model.afterSave', function() use ($value) {
                    $this->associate($value);
                });
            }

            $this->associate($value);
            $this->child->setRelation($this->relationName, $value);
        } else {
            $this->child->setAttribute($this->getForeignKeyName(), $value);
            $this->child->reloadRelations($this->relationName);
        }
    }

    /**
     * Helper for getting this relationship simple value,
     * generally useful with form values.
     */
    public function getSimpleValue()
    {
        return $this->child->getAttribute($this->getForeignKeyName());
    }

    /**
     * Get the associated key of the relationship.
     * @return string
     */
    public function getOtherKey()
    {
        return $this->ownerKey;
    }
}
