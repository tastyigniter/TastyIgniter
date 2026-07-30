<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyProgramAccrualRuleVisitData;
use Square\Models\Money;

/**
 * Builder for model LoyaltyProgramAccrualRuleVisitData
 *
 * @see LoyaltyProgramAccrualRuleVisitData
 */
class LoyaltyProgramAccrualRuleVisitDataBuilder
{
    /**
     * @var LoyaltyProgramAccrualRuleVisitData
     */
    private $instance;

    private function __construct(LoyaltyProgramAccrualRuleVisitData $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty program accrual rule visit data Builder object.
     */
    public static function init(string $taxMode): self
    {
        return new self(new LoyaltyProgramAccrualRuleVisitData($taxMode));
    }

    /**
     * Sets minimum amount money field.
     */
    public function minimumAmountMoney(?Money $value): self
    {
        $this->instance->setMinimumAmountMoney($value);
        return $this;
    }

    /**
     * Initializes a new loyalty program accrual rule visit data object.
     */
    public function build(): LoyaltyProgramAccrualRuleVisitData
    {
        return CoreHelper::clone($this->instance);
    }
}
