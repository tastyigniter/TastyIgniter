<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InvoiceSort;

/**
 * Builder for model InvoiceSort
 *
 * @see InvoiceSort
 */
class InvoiceSortBuilder
{
    /**
     * @var InvoiceSort
     */
    private $instance;

    private function __construct(InvoiceSort $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new invoice sort Builder object.
     */
    public static function init(): self
    {
        return new self(new InvoiceSort());
    }

    /**
     * Sets order field.
     */
    public function order(?string $value): self
    {
        $this->instance->setOrder($value);
        return $this;
    }

    /**
     * Initializes a new invoice sort object.
     */
    public function build(): InvoiceSort
    {
        return CoreHelper::clone($this->instance);
    }
}
