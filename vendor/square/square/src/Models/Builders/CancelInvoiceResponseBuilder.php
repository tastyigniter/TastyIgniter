<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CancelInvoiceResponse;
use Square\Models\Invoice;

/**
 * Builder for model CancelInvoiceResponse
 *
 * @see CancelInvoiceResponse
 */
class CancelInvoiceResponseBuilder
{
    /**
     * @var CancelInvoiceResponse
     */
    private $instance;

    private function __construct(CancelInvoiceResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel invoice response Builder object.
     */
    public static function init(): self
    {
        return new self(new CancelInvoiceResponse());
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
     * Initializes a new cancel invoice response object.
     */
    public function build(): CancelInvoiceResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
