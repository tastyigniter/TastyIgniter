<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Invoice;
use Square\Models\UpdateInvoiceResponse;

/**
 * Builder for model UpdateInvoiceResponse
 *
 * @see UpdateInvoiceResponse
 */
class UpdateInvoiceResponseBuilder
{
    /**
     * @var UpdateInvoiceResponse
     */
    private $instance;

    private function __construct(UpdateInvoiceResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update invoice response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateInvoiceResponse());
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
     * Initializes a new update invoice response object.
     */
    public function build(): UpdateInvoiceResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
