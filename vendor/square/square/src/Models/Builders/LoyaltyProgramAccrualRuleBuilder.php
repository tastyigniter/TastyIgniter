<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyProgramAccrualRule;
use Square\Models\LoyaltyProgramAccrualRuleCategoryData;
use Square\Models\LoyaltyProgramAccrualRuleItemVariationData;
use Square\Models\LoyaltyProgramAccrualRuleSpendData;
use Square\Models\LoyaltyProgramAccrualRuleVisitData;

/**
 * Builder for model LoyaltyProgramAccrualRule
 *
 * @see LoyaltyProgramAccrualRule
 */
class LoyaltyProgramAccrualRuleBuilder
{
    /**
     * @var LoyaltyProgramAccrualRule
     */
    private $instance;

    private function __construct(LoyaltyProgramAccrualRule $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty program accrual rule Builder object.
     */
    public static function init(string $accrualType): self
    {
        return new self(new LoyaltyProgramAccrualRule($accrualType));
    }

    /**
     * Sets points field.
     */
    public function points(?int $value): self
    {
        $this->instance->setPoints($value);
        return $this;
    }

    /**
     * Unsets points field.
     */
    public function unsetPoints(): self
    {
        $this->instance->unsetPoints();
        return $this;
    }

    /**
     * Sets visit data field.
     */
    public function visitData(?LoyaltyProgramAccrualRuleVisitData $value): self
    {
        $this->instance->setVisitData($value);
        return $this;
    }

    /**
     * Sets spend data field.
     */
    public function spendData(?LoyaltyProgramAccrualRuleSpendData $value): self
    {
        $this->instance->setSpendData($value);
        return $this;
    }

    /**
     * Sets item variation data field.
     */
    public function itemVariationData(?LoyaltyProgramAccrualRuleItemVariationData $value): self
    {
        $this->instance->setItemVariationData($value);
        return $this;
    }

    /**
     * Sets category data field.
     */
    public function categoryData(?LoyaltyProgramAccrualRuleCategoryData $value): self
    {
        $this->instance->setCategoryData($value);
        return $this;
    }

    /**
     * Initializes a new loyalty program accrual rule object.
     */
    public function build(): LoyaltyProgramAccrualRule
    {
        return CoreHelper::clone($this->instance);
    }
}
