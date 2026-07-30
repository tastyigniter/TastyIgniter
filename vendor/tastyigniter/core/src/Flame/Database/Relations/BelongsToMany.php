<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as CollectionBase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyBase;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Override;

/**
 * Adapted from october\rain\database\relations\BelongsToMany
 * @property \Igniter\Flame\Database\Model $parent
 */
class BelongsToMany extends BelongsToManyBase
{
    use DefinedConstraints;

    /**
     * @var bool This relation object is a 'count' helper.
     */
    public $countMode = false;

    /**
     * @var bool When a join is not used, don't select aliased columns.
     */
    public $orphanMode = false;

    /**
     * Create a new belongs to many relationship instance.
     *
     * @param string $table
     * @param string $foreignPivotKey
     * @param string $relatedPivotKey
     * @param string $relationName
     */
    public function __construct(
        Builder $query,
        Model $parent,
        $table,
        $foreignPivotKey,
        $relatedPivotKey,
        $parentKey,
        $relatedKey,
        $relationName = null,
    ) {
        parent::__construct(
            $query,
            $parent,
            $table,
            $foreignPivotKey,
            $relatedPivotKey,
            $parentKey,
            $relatedKey,
            $relationName,
        );

        $this->addDefinedConstraints();
    }

    /**
     * Override attach() method of BelongsToMany relation.
     * This is necessary in order to fire 'model.relation.beforeAttach', 'model.relation.afterAttach' events
     */
    #[Override]
    public function attach($id, array $attributes = [], $touch = true): void
    {
        // Normalize identifiers for events, this occurs internally in the parent logic
        // and should have no cascading effects.
        $parsedIds = $this->parseIds($id);

        if ($this->parent->fireEvent('model.relation.beforeAttach', [$this->relationName, &$parsedIds, &$attributes], true) === false) {
            return;
        }

        parent::attach($parsedIds, $attributes, $touch);

        $this->parent->fireEvent('model.relation.afterAttach', [$this->relationName, $parsedIds, $attributes]);
    }

    /**
     * Override detach() method of BelongsToMany relation.
     * This is necessary in order to fire 'model.relation.beforeDetach', 'model.relation.afterDetach' events
     * @param bool $touch
     */
    #[Override]
    public function detach($ids = null, $touch = true): int
    {
        // Normalize identifiers for events, this occurs internally in the parent logic
        // and should have no cascading effects. Null is used to detach everything.
        $parsedIds = $ids !== null ? $this->parseIds($ids) : $ids;

        if ($this->parent->fireEvent('model.relation.beforeDetach', [$this->relationName, &$parsedIds], true) === false) {
            return 0;
        }

        $results = parent::detach($parsedIds, $touch);

        $this->parent->fireEvent('model.relation.afterDetach', [$this->relationName, $parsedIds, $results]);

        return $results;
    }

    /**
     * Adds a model to this relationship type.
     */
    public function add(Model $model, array $pivotData = []): void
    {
        if ($this->parent->exists) {
            $this->attach($model, $pivotData);
        } else {
            $this->parent->bindEventOnce('model.afterSave', function() use ($model, $pivotData) {
                $this->attach($model, $pivotData);
            });
        }

        $this->parent->unsetRelation($this->relationName);
    }

    /**
     * Removes a model from this relationship type.
     */
    public function remove(Model $model): void
    {
        $this->detach($model->getKey());
        $this->parent->reloadRelations($this->relationName);
    }

    /**
     * Create a new pivot model instance.
     *
     * @param bool $exists
     * @return Pivot
     */
    #[Override]
    public function newPivot(array $attributes = [], $exists = false)
    {
        $attributes = array_merge(array_column($this->pivotValues, 'value', 'column'), $attributes);

        // October looks to the relationship parent
        $pivot = $this->parent->newRelationPivot($this->relationName, $this->parent, $attributes, $this->table, $exists);

        // Laravel looks to the related model
        if (empty($pivot)) {
            $pivot = $this->related->newPivot($this->parent, $attributes, $this->table, $exists);
        }

        return $pivot
            ->setPivotKeys($this->foreignPivotKey, $this->relatedPivotKey)
            ->setRelatedModel($this->related);
    }

    /**
     * Helper for setting this relationship using various expected
     * values. For example, $model->relation = $value;
     */
    public function setSimpleValue($value): void
    {
        // Nulling the relationship
        if (!$value) {
            // Disassociate in memory immediately
            $this->parent->setRelation($this->relationName, $this->getRelated()->newCollection());

            // Perform sync when the model is saved
            $this->parent->bindEventOnce('model.afterSave', function() {
                $this->detach();
            });

            return;
        }

        // Convert models to keys
        if ($value instanceof Model) {
            $value = $value->{$this->getRelatedKeyName()};
        } elseif (is_array($value)) {
            foreach ($value as $_key => $_value) {
                if ($_value instanceof Model) {
                    $value[$_key] = $_value->{$this->getRelatedKeyName()};
                }
            }
        }

        // Setting the relationship
        $relationCollection = $value instanceof CollectionBase
            ? $value
            : $this->newSimpleRelationQuery((array)$value)->get();

        // Associate in memory immediately
        $this->parent->setRelation($this->relationName, $relationCollection);

        // Perform sync when the model is saved
        $this->parent->bindEventOnce('model.afterSave', function() use ($value) {
            $this->sync($value);
        });
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
            $value = $this->allRelatedIds()->all();
        }

        return $value;
    }

    /**
     * Get the fully qualified foreign key for the relation.
     */
    public function getForeignKey(): string
    {
        return $this->table.'.'.$this->foreignPivotKey;
    }

    /**
     * Get the fully qualified "other key" for the relation.
     */
    public function getOtherKey(): string
    {
        return $this->table.'.'.$this->relatedPivotKey;
    }

    /**
     * Get the select columns for the relation query.
     */
    #[Override]
    protected function shouldSelect(array $columns = ['*']): array
    {
        if ($this->countMode) {
            return [$this->table.'.'.$this->foreignPivotKey.' as pivot_'.$this->foreignPivotKey];
        }

        if ($columns == ['*']) {
            $columns = [$this->related->getTable().'.*'];
        }

        return array_merge($columns, $this->aliasedPivotColumns());
    }

    /**
     * newSimpleRelationQuery for the related instance based on an array of IDs.
     */
    protected function newSimpleRelationQuery(array $ids)
    {
        return $this->getRelated()->newQuery()->whereIn($this->getRelatedKeyName(), $ids);
    }
}
