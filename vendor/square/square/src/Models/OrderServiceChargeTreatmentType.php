<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates whether the service charge will be treated as a value-holding line item or
 * apportioned toward a line item.
 */
class OrderServiceChargeTreatmentType
{
    public const LINE_ITEM_TREATMENT = 'LINE_ITEM_TREATMENT';

    public const APPORTIONED_TREATMENT = 'APPORTIONED_TREATMENT';
}
