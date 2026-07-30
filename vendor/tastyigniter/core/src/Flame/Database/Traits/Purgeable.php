<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Traits;

use Exception;
use LogicException;

/**
 * Purgeable model trait
 *
 * Usage:
 **
 * In the model class definition:
 *
 *   use \Igniter\Flame\Database\Traits\Purgeable;
 *
 * You must set attribute names which should not be saved to the database:
 *
 *   protected $purgeable = ['password'];
 */
trait Purgeable
{
    /**
     * @var array List of original attribute values before they were purged.
     */
    protected $originalPurgeableValues = [];

    /**
     * Boot the purgeable trait for a model.
     * @throws Exception
     */
    public static function bootPurgeable(): void
    {
        if (!property_exists(static::class, 'purgeable')) {
            throw new LogicException(sprintf(
                'You must define a $purgeable property in %s to use the Purgeable trait.', static::class,
            ));
        }

        /*
         * Remove any purge attributes from the data set
         */
        static::extend(function($model) {
            $model->bindEvent('model.saveInternal', function() use ($model) {
                $model->purgeAttributes();
            });
        });
    }

    /**
     * Adds an attribute to the purgeable attributes list
     *
     * @param array|string|null $attributes
     *
     * @return $this
     */
    public function addPurgeable($attributes = null)
    {
        $attributes = is_array($attributes) ? $attributes : func_get_args();

        $this->purgeable = array_merge($this->purgeable, $attributes);

        return $this;
    }

    /**
     * Removes purged attributes, used before saving.
     *
     * @return array Clean attributes
     */
    public function purgeAttributes($attributesToPurge = null)
    {
        if ($attributesToPurge !== null) {
            $purgeable = is_array($attributesToPurge) ? $attributesToPurge : [$attributesToPurge];
        } else {
            $purgeable = $this->getPurgeableAttributes();
        }

        $attributes = $this->getAttributes();
        $cleanAttributes = array_diff_key($attributes, array_flip($purgeable));
        $originalAttributes = array_diff_key($attributes, $cleanAttributes);

        $this->originalPurgeableValues = $originalAttributes;

        return $this->attributes = $cleanAttributes;
    }

    /**
     * Returns a collection of fields to be hashed.
     */
    public function getPurgeableAttributes()
    {
        return $this->purgeable;
    }

    /**
     * Returns the original values.
     */
    public function getOriginalPurgeValues()
    {
        return $this->originalPurgeableValues;
    }

    /**
     * Returns the original value of a single attribute.
     */
    public function getOriginalPurgeValue($attribute)
    {
        return array_get($this->getOriginalPurgeValues(), $attribute);
    }

    /**
     * Restores the original values.
     */
    public function restorePurgedValues()
    {
        $this->setRawAttributes(array_merge($this->getAttributes(), $this->getOriginalPurgeValues()));

        return $this;
    }
}
