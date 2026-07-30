<?php

declare(strict_types=1);

namespace Igniter\Flame\Html;

class HtmlBuilder
{
    /**
     * Build an HTML attribute string from an array.
     *
     * @param array $attributes
     */
    public function attributes($attributes): string
    {
        $html = [];

        foreach ((array)$attributes as $key => $value) {
            $element = $this->attributeElement($key, $value);

            if (!is_null($element)) {
                $html[] = $element;
            }
        }

        return $html !== [] ? ' '.implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param string $key
     * @param string $value
     *
     * @return ?string
     */
    protected function attributeElement($key, $value)
    {
        // For numeric keys we will assume that the value is a boolean attribute
        // where the presence of the attribute represents a true value and the
        // absence represents a false value.
        // This will convert HTML attributes such as "required" to a correct
        // form instead of using incorrect numerics.
        if (is_numeric($key)) {
            return $value;
        }

        // Treat boolean attributes as HTML properties
        if (is_bool($value) && $key != 'value') {
            return $value ? $key : '';
        }

        if (!is_null($value)) {
            return $key.'="'.e($value).'"';
        }

        return null;
    }
}
