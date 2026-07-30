<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates how taxes should be treated when calculating the purchase amount used for loyalty points
 * accrual.
 * This setting applies only to `SPEND` accrual rules or `VISIT` accrual rules that have a minimum
 * spend requirement.
 */
class LoyaltyProgramAccrualRuleTaxMode
{
    /**
     * Exclude taxes from the purchase amount used for loyalty points accrual.
     */
    public const BEFORE_TAX = 'BEFORE_TAX';

    /**
     * Include taxes in the purchase amount used for loyalty points accrual.
     */
    public const AFTER_TAX = 'AFTER_TAX';
}
