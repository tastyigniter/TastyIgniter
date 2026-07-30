<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyProgramAccrualRuleItemVariationData;

/**
 * Builder for model LoyaltyProgramAccrualRuleItemVariationData
 *
 * @see LoyaltyProgramAccrualRuleItemVariationData
 */
class LoyaltyProgramAccrualRuleItemVariationDataBuilder
{
    /**
     * @var LoyaltyProgramAccrualRuleItemVariationData
     */
    private $instance;

    private function __construct(LoyaltyProgramAccrualRuleItemVariationData $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty program accrual rule item variation data Builder object.
     */
    public static function init(string $itemVariationId): self
    {
        return new self(new LoyaltyProgramAccrualRuleItemVariationData($itemVariationId));
    }

    /**
     * Initializes a new loyalty program accrual rule item variation data object.
     */
    public function build(): LoyaltyProgramAccrualRuleItemVariationData
    {
        return CoreHelper::clone($this->instance);
    }
}
