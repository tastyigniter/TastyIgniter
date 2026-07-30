<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PublishInvoiceRequest;

/**
 * Builder for model PublishInvoiceRequest
 *
 * @see PublishInvoiceRequest
 */
class PublishInvoiceRequestBuilder
{
    /**
     * @var PublishInvoiceRequest
     */
    private $instance;

    private function __construct(PublishInvoiceRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new publish invoice request Builder object.
     */
    public static function init(int $version): self
    {
        return new self(new PublishInvoiceRequest($version));
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
     * Initializes a new publish invoice request object.
     */
    public function build(): PublishInvoiceRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
