<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyProgramAccrualRuleCategoryData;

/**
 * Builder for model LoyaltyProgramAccrualRuleCategoryData
 *
 * @see LoyaltyProgramAccrualRuleCategoryData
 */
class LoyaltyProgramAccrualRuleCategoryDataBuilder
{
    /**
     * @var LoyaltyProgramAccrualRuleCategoryData
     */
    private $instance;

    private function __construct(LoyaltyProgramAccrualRuleCategoryData $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty program accrual rule category data Builder object.
     */
    public static function init(string $categoryId): self
    {
        return new self(new LoyaltyProgramAccrualRuleCategoryData($categoryId));
    }

    /**
     * Initializes a new loyalty program accrual rule category data object.
     */
    public function build(): LoyaltyProgramAccrualRuleCategoryData
    {
        return CoreHelper::clone($this->instance);
    }
}
