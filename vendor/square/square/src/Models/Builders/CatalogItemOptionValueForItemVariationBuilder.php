<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogItemOptionValueForItemVariation;

/**
 * Builder for model CatalogItemOptionValueForItemVariation
 *
 * @see CatalogItemOptionValueForItemVariation
 */
class CatalogItemOptionValueForItemVariationBuilder
{
    /**
     * @var CatalogItemOptionValueForItemVariation
     */
    private $instance;

    private function __construct(CatalogItemOptionValueForItemVariation $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog item option value for item variation Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogItemOptionValueForItemVariation());
    }

    /**
     * Sets item option id field.
     */
    public function itemOptionId(?string $value): self
    {
        $this->instance->setItemOptionId($value);
        return $this;
    }

    /**
     * Unsets item option id field.
     */
    public function unsetItemOptionId(): self
    {
        $this->instance->unsetItemOptionId();
        return $this;
    }

    /**
     * Sets item option value id field.
     */
    public function itemOptionValueId(?string $value): self
    {
        $this->instance->setItemOptionValueId($value);
        return $this;
    }

    /**
     * Unsets item option value id field.
     */
    public function unsetItemOptionValueId(): self
    {
        $this->instance->unsetItemOptionValueId();
        return $this;
    }

    /**
     * Initializes a new catalog item option value for item variation object.
     */
    public function build(): CatalogItemOptionValueForItemVariation
    {
        return CoreHelper::clone($this->instance);
    }
}
