<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1CreateRefundRequest;
use Square\Models\V1Money;

/**
 * Builder for model V1CreateRefundRequest
 *
 * @see V1CreateRefundRequest
 */
class V1CreateRefundRequestBuilder
{
    /**
     * @var V1CreateRefundRequest
     */
    private $instance;

    private function __construct(V1CreateRefundRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 create refund request Builder object.
     */
    public static function init(string $paymentId, string $type, string $reason): self
    {
        return new self(new V1CreateRefundRequest($paymentId, $type, $reason));
    }

    /**
     * Sets refunded money field.
     */
    public function refundedMoney(?V1Money $value): self
    {
        $this->instance->setRefundedMoney($value);
        return $this;
    }

    /**
     * Sets request idempotence key field.
     */
    public function requestIdempotenceKey(?string $value): self
    {
        $this->instance->setRequestIdempotenceKey($value);
        return $this;
    }

    /**
     * Unsets request idempotence key field.
     */
    public function unsetRequestIdempotenceKey(): self
    {
        $this->instance->unsetRequestIdempotenceKey();
        return $this;
    }

    /**
     * Initializes a new v1 create refund request object.
     */
    public function build(): V1CreateRefundRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
