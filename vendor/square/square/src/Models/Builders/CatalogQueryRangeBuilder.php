<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogQueryRange;

/**
 * Builder for model CatalogQueryRange
 *
 * @see CatalogQueryRange
 */
class CatalogQueryRangeBuilder
{
    /**
     * @var CatalogQueryRange
     */
    private $instance;

    private function __construct(CatalogQueryRange $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog query range Builder object.
     */
    public static function init(string $attributeName): self
    {
        return new self(new CatalogQueryRange($attributeName));
    }

    /**
     * Sets attribute min value field.
     */
    public function attributeMinValue(?int $value): self
    {
        $this->instance->setAttributeMinValue($value);
        return $this;
    }

    /**
     * Unsets attribute min value field.
     */
    public function unsetAttributeMinValue(): self
    {
        $this->instance->unsetAttributeMinValue();
        return $this;
    }

    /**
     * Sets attribute max value field.
     */
    public function attributeMaxValue(?int $value): self
    {
        $this->instance->setAttributeMaxValue($value);
        return $this;
    }

    /**
     * Unsets attribute max value field.
     */
    public function unsetAttributeMaxValue(): self
    {
        $this->instance->unsetAttributeMaxValue();
        return $this;
    }

    /**
     * Initializes a new catalog query range object.
     */
    public function build(): CatalogQueryRange
    {
        return CoreHelper::clone($this->instance);
    }
}
