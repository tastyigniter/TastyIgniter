<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Enumeration of visibility-filter values used to set the ability to view custom attributes or custom
 * attribute definitions.
 */
class VisibilityFilter
{
    /**
     * All custom attributes or custom attribute definitions.
     */
    public const ALL = 'ALL';

    /**
     * All custom attributes or custom attribute definitions with the `visibility` field set to
     * `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     */
    public const READ = 'READ';

    /**
     * All custom attributes or custom attribute definitions with the `visibility` field set to
     * `VISIBILITY_READ_WRITE_VALUES`.
     */
    public const READ_WRITE = 'READ_WRITE';
}
