<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GetPaymentResponse;
use Square\Models\Payment;

/**
 * Builder for model GetPaymentResponse
 *
 * @see GetPaymentResponse
 */
class GetPaymentResponseBuilder
{
    /**
     * @var GetPaymentResponse
     */
    private $instance;

    private function __construct(GetPaymentResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get payment response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetPaymentResponse());
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
     * Initializes a new get payment response object.
     */
    public function build(): GetPaymentResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
