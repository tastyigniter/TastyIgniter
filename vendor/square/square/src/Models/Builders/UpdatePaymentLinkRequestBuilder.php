<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentLink;
use Square\Models\UpdatePaymentLinkRequest;

/**
 * Builder for model UpdatePaymentLinkRequest
 *
 * @see UpdatePaymentLinkRequest
 */
class UpdatePaymentLinkRequestBuilder
{
    /**
     * @var UpdatePaymentLinkRequest
     */
    private $instance;

    private function __construct(UpdatePaymentLinkRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update payment link request Builder object.
     */
    public static function init(PaymentLink $paymentLink): self
    {
        return new self(new UpdatePaymentLinkRequest($paymentLink));
    }

    /**
     * Initializes a new update payment link request object.
     */
    public function build(): UpdatePaymentLinkRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
