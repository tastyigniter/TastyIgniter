<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentRefund;
use Square\Models\RefundPaymentResponse;

/**
 * Builder for model RefundPaymentResponse
 *
 * @see RefundPaymentResponse
 */
class RefundPaymentResponseBuilder
{
    /**
     * @var RefundPaymentResponse
     */
    private $instance;

    private function __construct(RefundPaymentResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new refund payment response Builder object.
     */
    public static function init(): self
    {
        return new self(new RefundPaymentResponse());
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
     * Sets refund field.
     */
    public function refund(?PaymentRefund $value): self
    {
        $this->instance->setRefund($value);
        return $this;
    }

    /**
     * Initializes a new refund payment response object.
     */
    public function build(): RefundPaymentResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
