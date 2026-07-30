<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CancelPaymentResponse;
use Square\Models\Payment;

/**
 * Builder for model CancelPaymentResponse
 *
 * @see CancelPaymentResponse
 */
class CancelPaymentResponseBuilder
{
    /**
     * @var CancelPaymentResponse
     */
    private $instance;

    private function __construct(CancelPaymentResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel payment response Builder object.
     */
    public static function init(): self
    {
        return new self(new CancelPaymentResponse());
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
     * Initializes a new cancel payment response object.
     */
    public function build(): CancelPaymentResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
