<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Igniter\Flame\Database\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo as MorphToBase;
use Override;

/**
 * Adapted from october\rain\database\relations\MorphTo
 * @property Model $parent
 */
class MorphTo extends MorphToBase
{
    use DefinedConstraints;

    /**
     * @param string $relationName
     */
    public function __construct(Builder $query, Model $parent, $foreignKey, $otherKey, $type, /**
     * @var string The "name" of the relationship.
     */
        protected $relationName)
    {
        parent::__construct($query, $parent, $foreignKey, $otherKey, $type, $this->relationName);

        $this->addDefinedConstraints();
    }

    /**
     * Override associate() method of MorphTo relation.
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
     * Override dissociate() method of MorphTo relation.
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
            $this->parent->setRelation($this->relationName, $value);
        } elseif (is_array($value)) {
            [$modelId, $modelClass] = $value;
            $this->parent->setAttribute($this->foreignKey, $modelId);
            $this->parent->setAttribute($this->morphType, $modelClass);
            $this->parent->reloadRelations($this->relationName);
        } else {
            $this->parent->setAttribute($this->foreignKey, $value);
            $this->parent->reloadRelations($this->relationName);
        }
    }

    /**
     * Helper for getting this relationship simple value,
     * generally useful with form values.
     */
    public function getSimpleValue(): array
    {
        return [
            $this->parent->getAttribute($this->foreignKey),
            $this->parent->getAttribute($this->morphType),
        ];
    }
}
