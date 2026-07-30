<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;
use Override;

/**
 * Morph to many
 *
 * This class is a carbon copy of Illuminate\Database\Eloquent\Relations\MorphToMany
 * so the base Igniter\Flame\Database\Relations\BelongsToMany class can be inherited
 *
 * Adapted from october\rain\database\relations\MorphToMany
 * @property \Igniter\Flame\Database\Model $parent
 */
class MorphToMany extends BelongsToMany
{
    use DefinedConstraints;

    /**
     * The type of the polymorphic relation.
     */
    protected string $morphType;

    /**
     * The class name of the morph type constraint.
     *
     * @var string
     */
    protected $morphClass;

    /**
     * Create a new morph to many relationship instance.
     *
     * @param string $name
     * @param string $table
     * @param string $foreignKey
     * @param string $otherKey
     * @param string $relationName
     * @param bool $inverse
     */
    public function __construct(
        Builder $query,
        Model $parent,
        $name,
        $table,
        $foreignKey,
        $otherKey,
        $parentKey,
        $relatedKey,
        $relationName = null,
        protected $inverse = false,
    ) {
        $this->morphType = $name.'_type';

        $this->morphClass = $this->inverse ? $query->getModel()->getMorphClass() : $parent->getMorphClass();

        parent::__construct(
            $query,
            $parent,
            $table,
            $foreignKey,
            $otherKey,
            $parentKey,
            $relatedKey,
            $relationName,
        );

        $this->addDefinedConstraints();
    }

    /**
     * Set the where clause for the relation query.
     */
    #[Override]
    protected function addWhereConstraints(): static
    {
        parent::addWhereConstraints();

        $this->query->where($this->table.'.'.$this->morphType, $this->morphClass);

        return $this;
    }

    /**
     * Set the constraints for an eager load of the relation.
     */
    #[Override]
    public function addEagerConstraints(array $models): void
    {
        parent::addEagerConstraints($models);

        $this->query->where($this->table.'.'.$this->morphType, $this->morphClass);
    }

    /**
     * Create a new pivot attachment record.
     *
     * @param int $id
     * @param bool $timed
     * @return array
     */
    #[Override]
    protected function baseAttachRecord($id, $timed)
    {
        return Arr::add(
            parent::baseAttachRecord($id, $timed),
            $this->morphType,
            $this->morphClass,
        );
    }

    /**
     * Add the constraints for a relationship count query.
     *
     * @param array|mixed $columns
     * @return Builder
     */
    #[Override]
    public function getRelationExistenceQuery(Builder $query, Builder $parentQuery, $columns = ['*'])
    {
        return parent::getRelationExistenceQuery($query, $parentQuery, $columns)->where(
            $this->table.'.'.$this->morphType,
            $this->morphClass,
        );
    }

    /**
     * Create a new query builder for the pivot table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    #[Override]
    public function newPivotQuery()
    {
        return parent::newPivotQuery()->where($this->getMorphType(), $this->getMorphClass());
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
        // October looks to the relationship parent
        $pivot = $this->parent->newRelationPivot($this->relationName, $this->parent, $attributes, $this->table, $exists);

        // Laravel creates new pivot model this way
        if (empty($pivot)) {
            $using = $this->using;

            $pivot = $using ? $using::fromRawAttributes($this->parent, $attributes, $this->table, $exists)
                : MorphPivot::fromAttributes($this->parent, $attributes, $this->table, $exists);
        }

        $pivot->setPivotKeys($this->foreignPivotKey, $this->relatedPivotKey)
            ->setMorphType($this->morphType)
            ->setMorphClass($this->morphClass);

        return $pivot;
    }

    /**
     * Get the foreign key "type" name.
     */
    public function getMorphType(): string
    {
        return $this->morphType;
    }

    /**
     * Get the class name of the parent model.
     */
    public function getMorphClass(): string
    {
        return $this->morphClass;
    }
}
