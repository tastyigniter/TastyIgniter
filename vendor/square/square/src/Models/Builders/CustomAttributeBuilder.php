<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\CustomAttributeDefinition;

/**
 * Builder for model CustomAttribute
 *
 * @see CustomAttribute
 */
class CustomAttributeBuilder
{
    /**
     * @var CustomAttribute
     */
    private $instance;

    private function __construct(CustomAttribute $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new custom attribute Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomAttribute());
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
     * Unsets key field.
     */
    public function unsetKey(): self
    {
        $this->instance->unsetKey();
        return $this;
    }

    /**
     * Sets value field.
     */
    public function value($value): self
    {
        $this->instance->setValue($value);
        return $this;
    }

    /**
     * Unsets value field.
     */
    public function unsetValue(): self
    {
        $this->instance->unsetValue();
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets visibility field.
     */
    public function visibility(?string $value): self
    {
        $this->instance->setVisibility($value);
        return $this;
    }

    /**
     * Sets definition field.
     */
    public function definition(?CustomAttributeDefinition $value): self
    {
        $this->instance->setDefinition($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Initializes a new custom attribute object.
     */
    public function build(): CustomAttribute
    {
        return CoreHelper::clone($this->instance);
    }
}
