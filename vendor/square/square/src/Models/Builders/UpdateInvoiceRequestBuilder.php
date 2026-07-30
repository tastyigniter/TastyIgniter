<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Invoice;
use Square\Models\UpdateInvoiceRequest;

/**
 * Builder for model UpdateInvoiceRequest
 *
 * @see UpdateInvoiceRequest
 */
class UpdateInvoiceRequestBuilder
{
    /**
     * @var UpdateInvoiceRequest
     */
    private $instance;

    private function __construct(UpdateInvoiceRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update invoice request Builder object.
     */
    public static function init(Invoice $invoice): self
    {
        return new self(new UpdateInvoiceRequest($invoice));
    }

    /**
     * Sets idempotency key field.
     */
    public function idempotencyKey(?string $value): self
    {
        $this->instance->setIdempotencyKey($value);
        return $this;
    }

    /**
     * Unsets idempotency key field.
     */
    public function unsetIdempotencyKey(): self
    {
        $this->instance->unsetIdempotencyKey();
        return $this;
    }

    /**
     * Sets fields to clear field.
     */
    public function fieldsToClear(?array $value): self
    {
        $this->instance->setFieldsToClear($value);
        return $this;
    }

    /**
     * Unsets fields to clear field.
     */
    public function unsetFieldsToClear(): self
    {
        $this->instance->unsetFieldsToClear();
        return $this;
    }

    /**
     * Initializes a new update invoice request object.
     */
    public function build(): UpdateInvoiceRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
