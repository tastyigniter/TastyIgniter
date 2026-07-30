<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityImportReversal;
use Square\Models\Money;

/**
 * Builder for model GiftCardActivityImportReversal
 *
 * @see GiftCardActivityImportReversal
 */
class GiftCardActivityImportReversalBuilder
{
    /**
     * @var GiftCardActivityImportReversal
     */
    private $instance;

    private function __construct(GiftCardActivityImportReversal $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity import reversal Builder object.
     */
    public static function init(Money $amountMoney): self
    {
        return new self(new GiftCardActivityImportReversal($amountMoney));
    }

    /**
     * Initializes a new gift card activity import reversal object.
     */
    public function build(): GiftCardActivityImportReversal
    {
        return CoreHelper::clone($this->instance);
    }
}
