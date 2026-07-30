<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Traits;

use Igniter\Flame\Database\NestedSet\QueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Kalnoy\Nestedset\NodeTrait;

trait NestedTree
{
    use NodeTrait {
        NodeTrait::create as parentCreate;
    }

    /**
     * Get the lft key name.
     */
    public function getLftName(): string
    {
        return 'nest_left';
    }

    /**
     * Get the rgt key name.
     */
    public function getRgtName(): string
    {
        return 'nest_right';
    }

    /**
     * Get the parent id key name.
     */
    public function getParentIdName(): string
    {
        return 'parent_id';
    }

    public static function create(array $attributes = [], $parent = null)
    {
        $children = array_pull($attributes, 'children');

        $instance = new static($attributes);

        if ($parent instanceof self) {
            $instance->appendToNode($parent);
        }

        $instance->save();

        // Now create children
        $relation = new EloquentCollection;

        foreach ((array)$children as $child) {
            $relation->add($child = static::create($child, $instance));

            $child->setRelation('parent', $instance);
        }

        $instance->refreshNode();

        return $instance->setRelation('children', $relation);
    }

    public function fixBrokenTreeQuietly(): void
    {
        self::withoutEvents(function() {
            self::fixTree();
        });
    }

    /**
     * {@inheritdoc}
     *
     * @since 2.0
     */
    public function newEloquentBuilder($query): QueryBuilder
    {
        return new QueryBuilder($query);
    }
}
