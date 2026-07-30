<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Relations;

use Illuminate\Database\Eloquent\Model;

/**
 * Adapted from october\rain\database\relations\HasOneOrMany
 * @property \Igniter\Flame\Database\Model $parent
 */
trait HasOneOrMany
{
    /**
     * @var string The "name" of the relationship.
     */
    protected $relationName;

    /**
     * saveMany is an alias for the addMany() method
     * @param array $models
     * @return array
     */
    public function saveMany($models, $sessionKey = null)
    {
        $this->addMany($models, $sessionKey);

        return $models;
    }

    /**
     * Adds a model to this relationship type.
     */
    public function add(Model $model): void
    {
        if ($this->parent->fireEvent('model.relation.beforeAdd', [$this->relationName, $model], true) === false) {
            return;
        }

        // Associate the model
        if ($this->parent->exists) {
            $model->setAttribute($this->getForeignKeyName(), $this->getParentKey());
            $model->save();
        } else {
            $this->parent->bindEventOnce('model.afterSave', function() use ($model) {
                $model->setAttribute($this->getForeignKeyName(), $this->getParentKey());
                $model->save();
            });
        }

        // Use the opportunity to set the relation in memory
        if ($this instanceof HasOne) {
            $this->parent->setRelation($this->relationName, $model);
        } else {
            $this->parent->unsetRelation($this->relationName);
        }

        $this->parent->fireEvent('model.relation.add', [$this->relationName, $model]);
    }

    /**
     * Attach an array of models to the parent instance with deferred binding support.
     * @param array $models
     */
    public function addMany($models): void
    {
        foreach ($models as $model) {
            $this->add($model);
        }
    }

    /**
     * Removes a model from this relationship type.
     */
    public function remove(Model $model): void
    {
        if ($this->parent->fireEvent('model.relation.beforeRemove', [$this->relationName, $model], true) === false) {
            return;
        }

        if (!$this->isModelRemovable($model)) {
            return;
        }

        $options = $this->parent->getRelationDefinition($this->relationName);

        // Delete or orphan the model
        if (array_get($options, 'delete', false)) {
            $model->delete();
        } else {
            $model->setAttribute($this->getForeignKeyName(), null);
            $model->save();
        }

        // Use the opportunity to set the relation in memory
        if ($this instanceof HasOne) {
            $this->parent->setRelation($this->relationName, null);
        } else {
            $this->parent->unsetRelation($this->relationName);
        }

        $this->parent->fireEvent('model.relation.remove', [$this->relationName, $model]);
    }

    /**
     * Returns true if an existing model is already associated
     */
    protected function isModelRemovable($model): bool
    {
        return (string)$model->getAttribute($this->getForeignKeyName()) === (string)$this->getParentKey();
    }

    /**
     * Ensures the relation is empty, either deleted or nulled.
     */
    protected function ensureRelationIsEmpty()
    {
        $options = $this->parent->getRelationDefinition($this->relationName);

        if (array_get($options, 'delete', false)) {
            $this->delete();
        } else {
            $this->update([$this->getForeignKeyName() => null]);
        }
    }

    public function getRelatedKeyName()
    {
        return $this->related->getKeyName();
    }

    /**
     * Get the foreign key for the relationship.
     * @return string
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * Get the associated "other" key of the relationship.
     * @return string
     */
    public function getOtherKey()
    {
        return $this->localKey;
    }
}
