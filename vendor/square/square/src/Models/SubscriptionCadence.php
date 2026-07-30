<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Determines the billing cadence of a [Subscription]($m/Subscription)
 */
class SubscriptionCadence
{
    /**
     * Once per day
     */
    public const DAILY = 'DAILY';

    /**
     * Once per week
     */
    public const WEEKLY = 'WEEKLY';

    /**
     * Every two weeks
     */
    public const EVERY_TWO_WEEKS = 'EVERY_TWO_WEEKS';

    /**
     * Once every 30 days
     */
    public const THIRTY_DAYS = 'THIRTY_DAYS';

    /**
     * Once every 60 days
     */
    public const SIXTY_DAYS = 'SIXTY_DAYS';

    /**
     * Once every 90 days
     */
    public const NINETY_DAYS = 'NINETY_DAYS';

    /**
     * Once per month
     */
    public const MONTHLY = 'MONTHLY';

    /**
     * Once every two months
     */
    public const EVERY_TWO_MONTHS = 'EVERY_TWO_MONTHS';

    /**
     * Once every three months
     */
    public const QUARTERLY = 'QUARTERLY';

    /**
     * Once every four months
     */
    public const EVERY_FOUR_MONTHS = 'EVERY_FOUR_MONTHS';

    /**
     * Once every six months
     */
    public const EVERY_SIX_MONTHS = 'EVERY_SIX_MONTHS';

    /**
     * Once per year
     */
    public const ANNUAL = 'ANNUAL';

    /**
     * Once every two years
     */
    public const EVERY_TWO_YEARS = 'EVERY_TWO_YEARS';
}
