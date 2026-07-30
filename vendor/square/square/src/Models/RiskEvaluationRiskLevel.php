<?php

declare(strict_types=1);

namespace Square\Models;

class RiskEvaluationRiskLevel
{
    /**
     * Indicates Square is still evaluating the payment.
     */
    public const PENDING = 'PENDING';

    /**
     * Indicates payment risk is within the normal range.
     */
    public const NORMAL = 'NORMAL';

    /**
     * Indicates elevated risk level associated with the payment.
     */
    public const MODERATE = 'MODERATE';

    /**
     * Indicates significantly elevated risk level with the payment.
     */
    public const HIGH = 'HIGH';
}
