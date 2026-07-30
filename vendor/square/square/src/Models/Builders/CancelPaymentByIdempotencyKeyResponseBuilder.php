<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CancelPaymentByIdempotencyKeyResponse;

/**
 * Builder for model CancelPaymentByIdempotencyKeyResponse
 *
 * @see CancelPaymentByIdempotencyKeyResponse
 */
class CancelPaymentByIdempotencyKeyResponseBuilder
{
    /**
     * @var CancelPaymentByIdempotencyKeyResponse
     */
    private $instance;

    private function __construct(CancelPaymentByIdempotencyKeyResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel payment by idempotency key response Builder object.
     */
    public static function init(): self
    {
        return new self(new CancelPaymentByIdempotencyKeyResponse());
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
     * Initializes a new cancel payment by idempotency key response object.
     */
    public function build(): CancelPaymentByIdempotencyKeyResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
