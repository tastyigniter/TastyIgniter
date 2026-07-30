<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Unit of weight used to measure a quantity.
 */
class MeasurementUnitWeight
{
    /**
     * The weight is measured in ounces.
     */
    public const IMPERIAL_WEIGHT_OUNCE = 'IMPERIAL_WEIGHT_OUNCE';

    /**
     * The weight is measured in pounds.
     */
    public const IMPERIAL_POUND = 'IMPERIAL_POUND';

    /**
     * The weight is measured in stones.
     */
    public const IMPERIAL_STONE = 'IMPERIAL_STONE';

    /**
     * The weight is measured in milligrams.
     */
    public const METRIC_MILLIGRAM = 'METRIC_MILLIGRAM';

    /**
     * The weight is measured in grams.
     */
    public const METRIC_GRAM = 'METRIC_GRAM';

    /**
     * The weight is measured in kilograms.
     */
    public const METRIC_KILOGRAM = 'METRIC_KILOGRAM';
}
