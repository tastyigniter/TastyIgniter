<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateInvoiceResponse;
use Square\Models\Invoice;

/**
 * Builder for model CreateInvoiceResponse
 *
 * @see CreateInvoiceResponse
 */
class CreateInvoiceResponseBuilder
{
    /**
     * @var CreateInvoiceResponse
     */
    private $instance;

    private function __construct(CreateInvoiceResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create invoice response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateInvoiceResponse());
    }

    /**
     * Sets invoice field.
     */
    public function invoice(?Invoice $value): self
    {
        $this->instance->setInvoice($value);
        return $this;
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new create invoice response object.
     */
    public function build(): CreateInvoiceResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
