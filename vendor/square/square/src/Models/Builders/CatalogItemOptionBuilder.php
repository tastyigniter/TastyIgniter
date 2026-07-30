<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogItemOption;

/**
 * Builder for model CatalogItemOption
 *
 * @see CatalogItemOption
 */
class CatalogItemOptionBuilder
{
    /**
     * @var CatalogItemOption
     */
    private $instance;

    private function __construct(CatalogItemOption $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog item option Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogItemOption());
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
     * Sets display name field.
     */
    public function displayName(?string $value): self
    {
        $this->instance->setDisplayName($value);
        return $this;
    }

    /**
     * Unsets display name field.
     */
    public function unsetDisplayName(): self
    {
        $this->instance->unsetDisplayName();
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
     * Sets show colors field.
     */
    public function showColors(?bool $value): self
    {
        $this->instance->setShowColors($value);
        return $this;
    }

    /**
     * Unsets show colors field.
     */
    public function unsetShowColors(): self
    {
        $this->instance->unsetShowColors();
        return $this;
    }

    /**
     * Sets values field.
     */
    public function values(?array $value): self
    {
        $this->instance->setValues($value);
        return $this;
    }

    /**
     * Unsets values field.
     */
    public function unsetValues(): self
    {
        $this->instance->unsetValues();
        return $this;
    }

    /**
     * Initializes a new catalog item option object.
     */
    public function build(): CatalogItemOption
    {
        return CoreHelper::clone($this->instance);
    }
}
