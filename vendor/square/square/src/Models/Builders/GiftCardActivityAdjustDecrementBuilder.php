<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityAdjustDecrement;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivityAdjustDecrement
 *
 * @see GiftCardActivityAdjustDecrement
 */
class GiftCardActivityAdjustDecrementBuilder
{
    /**
     * @var GiftCardActivityAdjustDecrement
     */
    private $instance;

    private function __construct(GiftCardActivityAdjustDecrement $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity adjust decrement Builder object.
     */
    public static function init(Money $amountMoney, string $reason): self
    {
        return new self(new GiftCardActivityAdjustDecrement($amountMoney, $reason));
    }

    /**
     * Initializes a new gift card activity adjust decrement object.
     */
    public function build(): GiftCardActivityAdjustDecrement
    {
        return CoreHelper::clone($this->instance);
    }
}
