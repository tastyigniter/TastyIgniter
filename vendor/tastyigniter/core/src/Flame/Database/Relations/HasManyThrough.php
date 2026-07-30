<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough as HasManyThroughBase;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Adapted from october\rain\database\relations\HasManyThrough
 */
class HasManyThrough extends HasManyThroughBase
{
    use DefinedConstraints;

    /**
     * Create a new has many relationship instance.
     * @param string $relationName
     */
    public function __construct(
        Builder $query,
        Model $farParent,
        Model $parent,
        $firstKey,
        $secondKey,
        $localKey,
        $secondLocalKey,
        /**
         * @var string The "name" of the relationship.
         */
        protected $relationName = null,
    ) {
        parent::__construct($query, $farParent, $parent, $firstKey, $secondKey, $localKey, $secondLocalKey);

        $this->addDefinedConstraints();
    }

    /**
     * Determine whether close parent of the relation uses Soft Deletes.
     */
    public function parentSoftDeletes(): bool
    {
        return in_array(SoftDeletes::class, class_uses_recursive($this->parent::class));
    }

    /**
     * Helper for getting this relationship simple value,
     * generally useful with form values.
     */
    public function getSimpleValue()
    {
        $relationName = $this->relationName;

        return $this->farParent->relationLoaded($relationName)
            ? $this->farParent->getRelation($relationName)->pluck($this->getRelatedKeyName())->all()
            : $this->query->getQuery()->pluck($this->getQualifiedRelatedKeyName())->all();
    }

    /**
     * getRelatedKeyName
     * @return string
     */
    public function getRelatedKeyName()
    {
        return $this->related->getKeyName();
    }

    /**
     * getQualifiedRelatedKeyName
     * @return string
     */
    public function getQualifiedRelatedKeyName()
    {
        return $this->related->getQualifiedKeyName();
    }
}
