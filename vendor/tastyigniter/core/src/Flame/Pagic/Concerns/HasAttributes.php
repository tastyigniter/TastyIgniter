<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasAttributes
{
    /**
     * The model's attributes.
     */
    public array $attributes = [];

    /**
     * The model attribute's original state.
     */
    protected array $original = [];

    /**
     * The changed model attributes.
     */
    protected array $changes = [];

    /**
     * Indicates whether attributes are snake cased on arrays.
     */
    public static bool $snakeAttributes = true;

    /**
     * The cache of the mutated attributes for each class.
     */
    protected static array $mutatorCache = [];

    /**
     * Convert the model's attributes to an array.
     */
    public function attributesToArray(): array
    {
        $attributes = $this->getArrayableAttributes();

        $attributes = $this->addMutatedAttributesToArray(
            $attributes, $this->getMutatedAttributes(),
        );

        // Here we will grab all of the appended, calculated attributes to this model
        // as these attributes are not really in the attributes array, but are run
        // when we need to array or JSON the model for convenience to the coder.
        foreach ($this->getArrayableAppends() as $key) {
            $attributes[$key] = $this->mutateAttributeForArray($key, null);
        }

        return $attributes;
    }

    /**
     * Add the mutated attributes to the attributes array.
     */
    protected function addMutatedAttributesToArray(array $attributes, array $mutatedAttributes): array
    {
        foreach ($mutatedAttributes as $key) {
            // We want to spin through all the mutated attributes for this model and call
            // the mutator for the attribute. We cache off every mutated attributes so
            // we don't have to constantly check on attributes that actually change.
            if (!array_key_exists($key, $attributes)) {
                continue;
            }

            // Next, we will call the mutator for this attribute so that we can get these
            // mutated attribute's actual values. After we finish mutating each of the
            // attributes we will return this final array of the mutated attributes.
            $attributes[$key] = $this->mutateAttributeForArray(
                $key, $attributes[$key],
            );
        }

        return $attributes;
    }

    /**
     * Get an attribute array of all arrayable attributes.
     */
    protected function getArrayableAttributes(): array
    {
        return $this->getArrayableItems($this->attributes);
    }

    /**
     * Get all of the appendable values that are arrayable.
     */
    protected function getArrayableAppends(): array
    {
        $defaults = [];

        if (empty($this->appends)) {
            return $defaults;
        }

        return array_merge($defaults, $this->appends);
    }

    /**
     * Get an attribute array of all arrayable values.
     */
    protected function getArrayableItems(array $values): array
    {
        if (count($this->getVisible()) > 0) {
            $values = array_intersect_key($values, array_flip($this->getVisible()));
        }

        if (count($this->getHidden()) > 0) {
            $values = array_diff_key($values, array_flip($this->getHidden()));
        }

        return $values;
    }

    /**
     * Get an attribute from the model.
     */
    public function getAttribute(string $key): mixed
    {
        // Before Event
        if (($attr = $this->fireEvent('model.beforeGetAttribute', [$key], true)) !== null) {
            return $attr;
        }

        if (empty($key)) {
            return null;
        }

        $value = null;

        if ($this->isSettingsAttribute($key)) {
            $value = $this->attributes['settings'][$key] ?? null;
        }
        // If the attribute exists in the attribute array or has a "get" mutator we will
        // get the attribute's value. Otherwise, we will proceed as if the developers
        // are asking for a relationship's value. This covers both types of values.
        elseif (array_key_exists($key, $this->attributes) ||
            $this->hasGetMutator($key)) {
            $value = $this->getAttributeValue($key);
        }

        // After Event
        if (($_attr = $this->fireEvent('model.getAttribute', [$key, $attr], true)) !== null) {
            return $_attr;
        }

        return $value;
    }

    /**
     * Get a plain attribute (not a relationship).
     */
    public function getAttributeValue(string $key): mixed
    {
        $value = $this->getAttributeFromArray($key);

        // If the attribute has a get mutator, we will call that then return what
        // it returns as the value, which is useful for transforming values on
        // retrieval from the model to a form that is more useful for usage.
        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key, $value);
        }

        return $value;
    }

    /**
     * Get an attribute from the $attributes array.
     */
    protected function getAttributeFromArray(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Determine if a get mutator exists for an attribute.
     */
    public function hasGetMutator(string $key): bool
    {
        return method_exists($this, 'get'.Str::studly($key).'Attribute');
    }

    /**
     * Get the value of an attribute using its mutator.
     */
    protected function mutateAttribute(string $key, mixed $value): mixed
    {
        return $this->{'get'.Str::studly($key).'Attribute'}($value);
    }

    /**
     * Get the value of an attribute using its mutator for array conversion.
     */
    protected function mutateAttributeForArray(string $key, mixed $value): mixed
    {
        $value = $this->mutateAttribute($key, $value);

        return $value instanceof Arrayable ? $value->toArray() : $value;
    }

    /**
     * Set a given attribute on the model.
     */
    public function setAttribute(string $key, mixed $value): self
    {
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            $this->{'set'.Str::studly($key).'Attribute'}($value);

            return $this;
        }

        if ($this->isSettingsAttribute($key)) {
            $this->attributes['settings'][$key] = $value;
        } else {
            $this->attributes[$key] = $value;
        }

        return $this;
    }

    /**
     * Determine if a set mutator exists for an attribute.
     */
    public function hasSetMutator(string $key): bool
    {
        return method_exists($this, 'set'.Str::studly($key).'Attribute');
    }

    /**
     * Get all of the current attributes on the model.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Set the array of model attributes. No checking is done.
     */
    public function setRawAttributes(array $attributes, bool $sync = false): self
    {
        $this->attributes = $attributes;

        if ($sync) {
            $this->syncOriginal();
        }

        return $this;
    }

    /**
     * Get the model's original attribute values.
     *
     * @return mixed|array
     */
    public function getOriginal(?string $key = null, mixed $default = null): mixed
    {
        return Arr::get($this->original, $key, $default);
    }

    /**
     * Get a subset of the model's attributes.
     */
    public function only(mixed $attributes): array
    {
        $results = [];

        foreach (is_array($attributes) ? $attributes : func_get_args() as $attribute) {
            $results[$attribute] = $this->getAttribute($attribute);
        }

        return $results;
    }

    /**
     * Sync the original attributes with the current.
     */
    public function syncOriginal(): self
    {
        $this->original = $this->attributes;

        return $this;
    }

    /**
     * Sync a single original attribute with its current value.
     */
    public function syncOriginalAttribute(string $attribute): self
    {
        $this->original[$attribute] = $this->attributes[$attribute];

        return $this;
    }

    /**
     * Sync the changed attributes.
     */
    public function syncChanges(): self
    {
        $this->changes = $this->getDirty();

        return $this;
    }

    /**
     * Determine if the model or given attribute(s) have been modified.
     */
    public function isDirty(array|string|null $attributes = null): bool
    {
        return $this->hasChanges($this->getDirty(), is_array($attributes) ? $attributes : func_get_args());
    }

    /**
     * Determine if the model or given attribute(s) have remained the same.
     */
    public function isClean(array|string|null $attributes = null): bool
    {
        return !$this->isDirty(...func_get_args());
    }

    /**
     * Determine if the model or given attribute(s) have been modified.
     */
    public function wasChanged(array|string|null $attributes = null): bool
    {
        return $this->hasChanges($this->getChanges(), is_array($attributes) ? $attributes : func_get_args());
    }

    /**
     * Determine if the given attributes were changed.
     */
    protected function hasChanges(array $changes, array|string|null $attributes = null): bool
    {
        // If no specific attributes were provided, we will just see if the dirty array
        // already contains any attributes. If it does we will just return that this
        // count is greater than zero. Else, we need to check specific attributes.
        if (empty($attributes)) {
            return $changes !== [];
        }

        // Here we will spin through every attribute and see if this is in the array of
        // dirty attributes. If it is, we will return true and if we make it through
        // all of the attributes for the entire array we will return false at end.
        foreach (Arr::wrap($attributes) as $attribute) {
            if (array_key_exists($attribute, $changes)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the attributes that have been changed since last sync.
     */
    public function getDirty(): array
    {
        $dirty = [];

        foreach ($this->getAttributes() as $key => $value) {
            if (!$this->originalIsEquivalent($key, $value)) {
                $dirty[$key] = $value;
            }
        }

        return $dirty;
    }

    /**
     * Get the attributes that was changed.
     */
    public function getChanges(): array
    {
        return $this->changes;
    }

    /**
     * Determine if the new and old values for a given key are equivalent.
     */
    protected function originalIsEquivalent(string $key, mixed $current): bool
    {
        if (!array_key_exists($key, $this->original)) {
            return false;
        }

        $original = $this->getOriginal($key);

        if ($current === $original) {
            return true;
        }

        return is_numeric($current) && is_numeric($original)
            && strcmp((string)$current, (string)$original) === 0;
    }

    public function isSettingsAttribute(string $attribute): bool
    {
        return !in_array($attribute, [
            'fileName',
            'baseFileName',
            'components',
            'content',
            'markup',
            'mTime',
            'code',
            'settings',
        ], true);
    }

    /**
     * Get the mutated attributes for a given instance.
     */
    public function getMutatedAttributes(): array
    {
        $class = static::class;

        if (!isset(static::$mutatorCache[$class])) {
            static::cacheMutatedAttributes($class);
        }

        return static::$mutatorCache[$class];
    }

    /**
     * Extract and cache all the mutated attributes of a class.
     */
    public static function cacheMutatedAttributes(string $class): void
    {
        static::$mutatorCache[$class] = collect(static::getMutatorMethods($class))->map(fn($match): string => lcfirst(static::$snakeAttributes ? Str::snake($match) : $match))->all();
    }

    /**
     * Get all of the attribute mutator methods.
     */
    protected static function getMutatorMethods(object|string $class): array
    {
        preg_match_all('/(?<=^|;)get([^;]+?)Attribute(;|$)/', implode(';', get_class_methods($class)), $matches);

        return $matches[1];
    }
}
