<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttributeDefinition;

/**
 * Builder for model CustomAttributeDefinition
 *
 * @see CustomAttributeDefinition
 */
class CustomAttributeDefinitionBuilder
{
    /**
     * @var CustomAttributeDefinition
     */
    private $instance;

    private function __construct(CustomAttributeDefinition $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new custom attribute definition Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomAttributeDefinition());
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
     * Sets schema field.
     */
    public function schema($value): self
    {
        $this->instance->setSchema($value);
        return $this;
    }

    /**
     * Unsets schema field.
     */
    public function unsetSchema(): self
    {
        $this->instance->unsetSchema();
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
     * Sets visibility field.
     */
    public function visibility(?string $value): self
    {
        $this->instance->setVisibility($value);
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
     * Initializes a new custom attribute definition object.
     */
    public function build(): CustomAttributeDefinition
    {
        return CoreHelper::clone($this->instance);
    }
}
