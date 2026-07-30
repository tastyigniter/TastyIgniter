<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogQueryItemVariationsForItemOptionValues;

/**
 * Builder for model CatalogQueryItemVariationsForItemOptionValues
 *
 * @see CatalogQueryItemVariationsForItemOptionValues
 */
class CatalogQueryItemVariationsForItemOptionValuesBuilder
{
    /**
     * @var CatalogQueryItemVariationsForItemOptionValues
     */
    private $instance;

    private function __construct(CatalogQueryItemVariationsForItemOptionValues $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog query item variations for item option values Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogQueryItemVariationsForItemOptionValues());
    }

    /**
     * Sets item option value ids field.
     */
    public function itemOptionValueIds(?array $value): self
    {
        $this->instance->setItemOptionValueIds($value);
        return $this;
    }

    /**
     * Unsets item option value ids field.
     */
    public function unsetItemOptionValueIds(): self
    {
        $this->instance->unsetItemOptionValueIds();
        return $this;
    }

    /**
     * Initializes a new catalog query item variations for item option values object.
     */
    public function build(): CatalogQueryItemVariationsForItemOptionValues
    {
        return CoreHelper::clone($this->instance);
    }
}
