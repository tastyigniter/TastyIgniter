<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogItemOptionValue;

/**
 * Builder for model CatalogItemOptionValue
 *
 * @see CatalogItemOptionValue
 */
class CatalogItemOptionValueBuilder
{
    /**
     * @var CatalogItemOptionValue
     */
    private $instance;

    private function __construct(CatalogItemOptionValue $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog item option value Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogItemOptionValue());
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
     * Sets description field.
     */
    public function description(?string $value): self
    {
        $this->instance->setDescription($value);
        return $this;
    }

    /**
     * Unsets description field.
     */
    public function unsetDescription(): self
    {
        $this->instance->unsetDescription();
        return $this;
    }

    /**
     * Sets color field.
     */
    public function color(?string $value): self
    {
        $this->instance->setColor($value);
        return $this;
    }

    /**
     * Unsets color field.
     */
    public function unsetColor(): self
    {
        $this->instance->unsetColor();
        return $this;
    }

    /**
     * Sets ordinal field.
     */
    public function ordinal(?int $value): self
    {
        $this->instance->setOrdinal($value);
        return $this;
    }

    /**
     * Unsets ordinal field.
     */
    public function unsetOrdinal(): self
    {
        $this->instance->unsetOrdinal();
        return $this;
    }

    /**
     * Initializes a new catalog item option value object.
     */
    public function build(): CatalogItemOptionValue
    {
        return CoreHelper::clone($this->instance);
    }
}
