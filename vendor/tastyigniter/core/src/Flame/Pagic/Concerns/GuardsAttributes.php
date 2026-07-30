<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Concerns;

use Illuminate\Support\Str;

trait GuardsAttributes
{
    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * Get the fillable attributes for the model.
     */
    public function getFillable(): array
    {
        return $this->fillable;
    }

    /**
     * Set the fillable attributes for the model.
     */
    public function fillable(array $fillable): self
    {
        $this->fillable = $fillable;

        return $this;
    }

    /**
     * Get the fillable attributes of a given array.
     */
    protected function fillableFromArray(array $attributes): array
    {
        if (count($this->getFillable()) > 0) {
            return array_intersect_key($attributes, array_flip(
                array_merge(['fileName'], $this->getFillable()),
            ));
        }

        return $attributes;
    }

    /**
     * Determine if the given attribute may be mass assigned.
     */
    public function isFillable(string $key): bool
    {
        // File name is always treated as a fillable attribute.
        if ($key === 'fileName') {
            return true;
        }

        // If the key is in the "fillable" array, we can of course assume that it's
        // a fillable attribute. Otherwise, we will check the guarded array when
        // we need to determine if the attribute is black-listed on the model.
        if (in_array($key, $this->getFillable())) {
            return true;
        }

        return empty($this->getFillable()) && !Str::startsWith($key, '_');
    }
}
