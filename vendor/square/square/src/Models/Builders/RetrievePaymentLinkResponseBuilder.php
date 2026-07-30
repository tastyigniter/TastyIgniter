<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentLink;
use Square\Models\RetrievePaymentLinkResponse;

/**
 * Builder for model RetrievePaymentLinkResponse
 *
 * @see RetrievePaymentLinkResponse
 */
class RetrievePaymentLinkResponseBuilder
{
    /**
     * @var RetrievePaymentLinkResponse
     */
    private $instance;

    private function __construct(RetrievePaymentLinkResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve payment link response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrievePaymentLinkResponse());
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
     * Sets payment link field.
     */
    public function paymentLink(?PaymentLink $value): self
    {
        $this->instance->setPaymentLink($value);
        return $this;
    }

    /**
     * Initializes a new retrieve payment link response object.
     */
    public function build(): RetrievePaymentLinkResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
