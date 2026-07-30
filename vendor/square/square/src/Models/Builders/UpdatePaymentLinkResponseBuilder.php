<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentLink;
use Square\Models\UpdatePaymentLinkResponse;

/**
 * Builder for model UpdatePaymentLinkResponse
 *
 * @see UpdatePaymentLinkResponse
 */
class UpdatePaymentLinkResponseBuilder
{
    /**
     * @var UpdatePaymentLinkResponse
     */
    private $instance;

    private function __construct(UpdatePaymentLinkResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update payment link response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdatePaymentLinkResponse());
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
     * Initializes a new update payment link response object.
     */
    public function build(): UpdatePaymentLinkResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
