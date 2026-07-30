<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GetPaymentRefundResponse;
use Square\Models\PaymentRefund;

/**
 * Builder for model GetPaymentRefundResponse
 *
 * @see GetPaymentRefundResponse
 */
class GetPaymentRefundResponseBuilder
{
    /**
     * @var GetPaymentRefundResponse
     */
    private $instance;

    private function __construct(GetPaymentRefundResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get payment refund response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetPaymentRefundResponse());
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
     * Initializes a new get payment refund response object.
     */
    public function build(): GetPaymentRefundResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
