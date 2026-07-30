<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogQuerySortedAttribute;

/**
 * Builder for model CatalogQuerySortedAttribute
 *
 * @see CatalogQuerySortedAttribute
 */
class CatalogQuerySortedAttributeBuilder
{
    /**
     * @var CatalogQuerySortedAttribute
     */
    private $instance;

    private function __construct(CatalogQuerySortedAttribute $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog query sorted attribute Builder object.
     */
    public static function init(string $attributeName): self
    {
        return new self(new CatalogQuerySortedAttribute($attributeName));
    }

    /**
     * Sets initial attribute value field.
     */
    public function initialAttributeValue(?string $value): self
    {
        $this->instance->setInitialAttributeValue($value);
        return $this;
    }

    /**
     * Unsets initial attribute value field.
     */
    public function unsetInitialAttributeValue(): self
    {
        $this->instance->unsetInitialAttributeValue();
        return $this;
    }

    /**
     * Sets sort order field.
     */
    public function sortOrder(?string $value): self
    {
        $this->instance->setSortOrder($value);
        return $this;
    }

    /**
     * Initializes a new catalog query sorted attribute object.
     */
    public function build(): CatalogQuerySortedAttribute
    {
        return CoreHelper::clone($this->instance);
    }
}
