<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Specifies which timestamp to use to sort `SearchOrder` results.
 */
class SearchOrdersSortField
{
    /**
     * The time when the order was created, in RFC-3339 format. If you are also
     * filtering for a time range in this query, you must set the `CREATED_AT`
     * field in your `DateTimeFilter`.
     */
    public const CREATED_AT = 'CREATED_AT';

    /**
     * The time when the order last updated, in RFC-3339 format. If you are also
     * filtering for a time range in this query, you must set the `UPDATED_AT`
     * field in your `DateTimeFilter`.
     */
    public const UPDATED_AT = 'UPDATED_AT';

    /**
     * The time when the order was closed, in RFC-3339 format. If you use this
     * value, you must also set a `StateFilter` with closed states. If you are also
     * filtering for a time range in this query, you must set the `CLOSED_AT`
     * field in your `DateTimeFilter`.
     */
    public const CLOSED_AT = 'CLOSED_AT';
}
