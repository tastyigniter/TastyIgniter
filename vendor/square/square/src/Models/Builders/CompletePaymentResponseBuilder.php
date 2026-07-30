<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CompletePaymentResponse;
use Square\Models\Payment;

/**
 * Builder for model CompletePaymentResponse
 *
 * @see CompletePaymentResponse
 */
class CompletePaymentResponseBuilder
{
    /**
     * @var CompletePaymentResponse
     */
    private $instance;

    private function __construct(CompletePaymentResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new complete payment response Builder object.
     */
    public static function init(): self
    {
        return new self(new CompletePaymentResponse());
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
     * Sets payment field.
     */
    public function payment(?Payment $value): self
    {
        $this->instance->setPayment($value);
        return $this;
    }

    /**
     * Initializes a new complete payment response object.
     */
    public function build(): CompletePaymentResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
