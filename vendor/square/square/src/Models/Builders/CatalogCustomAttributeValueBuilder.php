<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogCustomAttributeValue;

/**
 * Builder for model CatalogCustomAttributeValue
 *
 * @see CatalogCustomAttributeValue
 */
class CatalogCustomAttributeValueBuilder
{
    /**
     * @var CatalogCustomAttributeValue
     */
    private $instance;

    private function __construct(CatalogCustomAttributeValue $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog custom attribute value Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogCustomAttributeValue());
    }

    /**
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Unsets name field.
     */
    public function unsetName(): self
    {
        $this->instance->unsetName();
        return $this;
    }

    /**
     * Sets string value field.
     */
    public function stringValue(?string $value): self
    {
        $this->instance->setStringValue($value);
        return $this;
    }

    /**
     * Unsets string value field.
     */
    public function unsetStringValue(): self
    {
        $this->instance->unsetStringValue();
        return $this;
    }

    /**
     * Sets custom attribute definition id field.
     */
    public function customAttributeDefinitionId(?string $value): self
    {
        $this->instance->setCustomAttributeDefinitionId($value);
        return $this;
    }

    /**
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
    }

    /**
     * Sets number value field.
     */
    public function numberValue(?string $value): self
    {
        $this->instance->setNumberValue($value);
        return $this;
    }

    /**
     * Unsets number value field.
     */
    public function unsetNumberValue(): self
    {
        $this->instance->unsetNumberValue();
        return $this;
    }

    /**
     * Sets boolean value field.
     */
    public function booleanValue(?bool $value): self
    {
        $this->instance->setBooleanValue($value);
        return $this;
    }

    /**
     * Unsets boolean value field.
     */
    public function unsetBooleanValue(): self
    {
        $this->instance->unsetBooleanValue();
        return $this;
    }

    /**
     * Sets selection uid values field.
     */
    public function selectionUidValues(?array $value): self
    {
        $this->instance->setSelectionUidValues($value);
        return $this;
    }

    /**
     * Unsets selection uid values field.
     */
    public function unsetSelectionUidValues(): self
    {
        $this->instance->unsetSelectionUidValues();
        return $this;
    }

    /**
     * Sets key field.
     */
    public function key(?string $value): self
    {
        $this->instance->setKey($value);
        return $this;
    }

    /**
     * Initializes a new catalog custom attribute value object.
     */
    public function build(): CatalogCustomAttributeValue
    {
        return CoreHelper::clone($this->instance);
    }
}
