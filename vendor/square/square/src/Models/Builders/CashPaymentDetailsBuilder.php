<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CashPaymentDetails;
use Square\Models\Money;

/**
 * Builder for model CashPaymentDetails
 *
 * @see CashPaymentDetails
 */
class CashPaymentDetailsBuilder
{
    /**
     * @var CashPaymentDetails
     */
    private $instance;

    private function __construct(CashPaymentDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cash payment details Builder object.
     */
    public static function init(Money $buyerSuppliedMoney): self
    {
        return new self(new CashPaymentDetails($buyerSuppliedMoney));
    }

    /**
     * Sets change back money field.
     */
    public function changeBackMoney(?Money $value): self
    {
        $this->instance->setChangeBackMoney($value);
        return $this;
    }

    /**
     * Initializes a new cash payment details object.
     */
    public function build(): CashPaymentDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
