<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InvoiceCustomField;

/**
 * Builder for model InvoiceCustomField
 *
 * @see InvoiceCustomField
 */
class InvoiceCustomFieldBuilder
{
    /**
     * @var InvoiceCustomField
     */
    private $instance;

    private function __construct(InvoiceCustomField $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new invoice custom field Builder object.
     */
    public static function init(): self
    {
        return new self(new InvoiceCustomField());
    }

    /**
     * Sets label field.
     */
    public function label(?string $value): self
    {
        $this->instance->setLabel($value);
        return $this;
    }

    /**
     * Unsets label field.
     */
    public function unsetLabel(): self
    {
        $this->instance->unsetLabel();
        return $this;
    }

    /**
     * Sets value field.
     */
    public function value(?string $value): self
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
     * Sets placement field.
     */
    public function placement(?string $value): self
    {
        $this->instance->setPlacement($value);
        return $this;
    }

    /**
     * Initializes a new invoice custom field object.
     */
    public function build(): InvoiceCustomField
    {
        return CoreHelper::clone($this->instance);
    }
}
