<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The status of the Employee being retrieved.
 */
class EmployeeStatus
{
    /**
     * Specifies that the employee is in the Active state.
     */
    public const ACTIVE = 'ACTIVE';

    /**
     * Specifies that the employee is in the Inactive state.
     */
    public const INACTIVE = 'INACTIVE';
}
