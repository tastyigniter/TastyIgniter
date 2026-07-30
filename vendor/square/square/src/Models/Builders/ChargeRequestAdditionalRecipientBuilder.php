<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ChargeRequestAdditionalRecipient;
use Square\Models\Money;

/**
 * Builder for model ChargeRequestAdditionalRecipient
 *
 * @see ChargeRequestAdditionalRecipient
 */
class ChargeRequestAdditionalRecipientBuilder
{
    /**
     * @var ChargeRequestAdditionalRecipient
     */
    private $instance;

    private function __construct(ChargeRequestAdditionalRecipient $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new charge request additional recipient Builder object.
     */
    public static function init(string $locationId, string $description, Money $amountMoney): self
    {
        return new self(new ChargeRequestAdditionalRecipient($locationId, $description, $amountMoney));
    }

    /**
     * Initializes a new charge request additional recipient object.
     */
    public function build(): ChargeRequestAdditionalRecipient
    {
        return CoreHelper::clone($this->instance);
    }
}
