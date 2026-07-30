<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Invoice;
use Square\Models\PublishInvoiceResponse;

/**
 * Builder for model PublishInvoiceResponse
 *
 * @see PublishInvoiceResponse
 */
class PublishInvoiceResponseBuilder
{
    /**
     * @var PublishInvoiceResponse
     */
    private $instance;

    private function __construct(PublishInvoiceResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new publish invoice response Builder object.
     */
    public static function init(): self
    {
        return new self(new PublishInvoiceResponse());
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
     * Initializes a new publish invoice response object.
     */
    public function build(): PublishInvoiceResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
