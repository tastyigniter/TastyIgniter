<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreatePaymentLinkResponse;
use Square\Models\PaymentLink;
use Square\Models\PaymentLinkRelatedResources;

/**
 * Builder for model CreatePaymentLinkResponse
 *
 * @see CreatePaymentLinkResponse
 */
class CreatePaymentLinkResponseBuilder
{
    /**
     * @var CreatePaymentLinkResponse
     */
    private $instance;

    private function __construct(CreatePaymentLinkResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create payment link response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreatePaymentLinkResponse());
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
     * Sets related resources field.
     */
    public function relatedResources(?PaymentLinkRelatedResources $value): self
    {
        $this->instance->setRelatedResources($value);
        return $this;
    }

    /**
     * Initializes a new create payment link response object.
     */
    public function build(): CreatePaymentLinkResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
