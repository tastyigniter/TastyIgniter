<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentBalanceActivityThirdPartyFeeDetail;

/**
 * Builder for model PaymentBalanceActivityThirdPartyFeeDetail
 *
 * @see PaymentBalanceActivityThirdPartyFeeDetail
 */
class PaymentBalanceActivityThirdPartyFeeDetailBuilder
{
    /**
     * @var PaymentBalanceActivityThirdPartyFeeDetail
     */
    private $instance;

    private function __construct(PaymentBalanceActivityThirdPartyFeeDetail $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment balance activity third party fee detail Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentBalanceActivityThirdPartyFeeDetail());
    }

    /**
     * Sets payment id field.
     */
    public function paymentId(?string $value): self
    {
        $this->instance->setPaymentId($value);
        return $this;
    }

    /**
     * Unsets payment id field.
     */
    public function unsetPaymentId(): self
    {
        $this->instance->unsetPaymentId();
        return $this;
    }

    /**
     * Initializes a new payment balance activity third party fee detail object.
     */
    public function build(): PaymentBalanceActivityThirdPartyFeeDetail
    {
        return CoreHelper::clone($this->instance);
    }
}
