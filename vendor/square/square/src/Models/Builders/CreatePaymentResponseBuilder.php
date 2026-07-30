<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreatePaymentResponse;
use Square\Models\Payment;

/**
 * Builder for model CreatePaymentResponse
 *
 * @see CreatePaymentResponse
 */
class CreatePaymentResponseBuilder
{
    /**
     * @var CreatePaymentResponse
     */
    private $instance;

    private function __construct(CreatePaymentResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create payment response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreatePaymentResponse());
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
     * Initializes a new create payment response object.
     */
    public function build(): CreatePaymentResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
