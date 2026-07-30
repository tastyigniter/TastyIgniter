<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityTransferBalanceTo;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivityTransferBalanceTo
 *
 * @see GiftCardActivityTransferBalanceTo
 */
class GiftCardActivityTransferBalanceToBuilder
{
    /**
     * @var GiftCardActivityTransferBalanceTo
     */
    private $instance;

    private function __construct(GiftCardActivityTransferBalanceTo $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity transfer balance to Builder object.
     */
    public static function init(string $transferFromGiftCardId, Money $amountMoney): self
    {
        return new self(new GiftCardActivityTransferBalanceTo($transferFromGiftCardId, $amountMoney));
    }

    /**
     * Initializes a new gift card activity transfer balance to object.
     */
    public function build(): GiftCardActivityTransferBalanceTo
    {
        return CoreHelper::clone($this->instance);
    }
}
