<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CancelPaymentByIdempotencyKeyRequest;

/**
 * Builder for model CancelPaymentByIdempotencyKeyRequest
 *
 * @see CancelPaymentByIdempotencyKeyRequest
 */
class CancelPaymentByIdempotencyKeyRequestBuilder
{
    /**
     * @var CancelPaymentByIdempotencyKeyRequest
     */
    private $instance;

    private function __construct(CancelPaymentByIdempotencyKeyRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel payment by idempotency key request Builder object.
     */
    public static function init(string $idempotencyKey): self
    {
        return new self(new CancelPaymentByIdempotencyKeyRequest($idempotencyKey));
    }

    /**
     * Initializes a new cancel payment by idempotency key request object.
     */
    public function build(): CancelPaymentByIdempotencyKeyRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
