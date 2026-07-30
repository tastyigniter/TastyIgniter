<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The type of the accrual rule that defines how buyers can earn points.
 */
class LoyaltyProgramAccrualRuleType
{
    /**
     * A visit-based accrual rule. A buyer earns points for each visit.
     * You can specify the minimum purchase required.
     */
    public const VISIT = 'VISIT';

    /**
     * A spend-based accrual rule. A buyer earns points based on the amount
     * spent.
     */
    public const SPEND = 'SPEND';

    /**
     * An accrual rule based on an item variation. For example, accrue
     * points for purchasing a coffee.
     */
    public const ITEM_VARIATION = 'ITEM_VARIATION';

    /**
     * An accrual rule based on an item category. For example, accrue points
     * for purchasing any item in the "hot drink" category: coffee, tea, or hot cocoa.
     */
    public const CATEGORY = 'CATEGORY';
}
