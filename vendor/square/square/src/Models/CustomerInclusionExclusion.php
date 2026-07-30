<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates whether customers should be included in, or excluded from,
 * the result set when they match the filtering criteria.
 */
class CustomerInclusionExclusion
{
    /**
     * Customers should be included in the result set when they match the
     * filtering criteria.
     */
    public const INCLUDE_ = 'INCLUDE';

    /**
     * Customers should be excluded from the result set when they match
     * the filtering criteria.
     */
    public const EXCLUDE = 'EXCLUDE';
}
