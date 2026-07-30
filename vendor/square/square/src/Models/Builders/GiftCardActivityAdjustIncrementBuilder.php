<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityAdjustIncrement;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivityAdjustIncrement
 *
 * @see GiftCardActivityAdjustIncrement
 */
class GiftCardActivityAdjustIncrementBuilder
{
    /**
     * @var GiftCardActivityAdjustIncrement
     */
    private $instance;

    private function __construct(GiftCardActivityAdjustIncrement $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity adjust increment Builder object.
     */
    public static function init(Money $amountMoney, string $reason): self
    {
        return new self(new GiftCardActivityAdjustIncrement($amountMoney, $reason));
    }

    /**
     * Initializes a new gift card activity adjust increment object.
     */
    public function build(): GiftCardActivityAdjustIncrement
    {
        return CoreHelper::clone($this->instance);
    }
}
