<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Enumerates the possible pay types that a job can be assigned.
 */
class JobAssignmentPayType
{
    /**
     * The job does not have a defined pay type.
     */
    public const NONE = 'NONE';

    /**
     * The job pays an hourly rate.
     */
    public const HOURLY = 'HOURLY';

    /**
     * The job pays an annual salary.
     */
    public const SALARY = 'SALARY';
}
