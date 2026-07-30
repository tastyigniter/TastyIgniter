<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityTransferBalanceFrom;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivityTransferBalanceFrom
 *
 * @see GiftCardActivityTransferBalanceFrom
 */
class GiftCardActivityTransferBalanceFromBuilder
{
    /**
     * @var GiftCardActivityTransferBalanceFrom
     */
    private $instance;

    private function __construct(GiftCardActivityTransferBalanceFrom $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity transfer balance from Builder object.
     */
    public static function init(string $transferToGiftCardId, Money $amountMoney): self
    {
        return new self(new GiftCardActivityTransferBalanceFrom($transferToGiftCardId, $amountMoney));
    }

    /**
     * Initializes a new gift card activity transfer balance from object.
     */
    public function build(): GiftCardActivityTransferBalanceFrom
    {
        return CoreHelper::clone($this->instance);
    }
}
