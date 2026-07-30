<?php

namespace Mollie\Api\Types;

class OnboardingStatus
{
    /**
     * The onboarding is not completed and the merchant needs to provide (more) information
     */
    public const NEEDS_DATA = 'needs-data';

    /**
     * The merchant provided all information and Mollie needs to check this
     */
    public const IN_REVIEW = 'in-review';

    /**
     * The onboarding is completed
     */
    public const COMPLETED = 'completed';
}
