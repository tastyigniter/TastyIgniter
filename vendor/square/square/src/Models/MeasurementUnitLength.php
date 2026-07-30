<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The unit of length used to measure a quantity.
 */
class MeasurementUnitLength
{
    /**
     * The length is measured in inches.
     */
    public const IMPERIAL_INCH = 'IMPERIAL_INCH';

    /**
     * The length is measured in feet.
     */
    public const IMPERIAL_FOOT = 'IMPERIAL_FOOT';

    /**
     * The length is measured in yards.
     */
    public const IMPERIAL_YARD = 'IMPERIAL_YARD';

    /**
     * The length is measured in miles.
     */
    public const IMPERIAL_MILE = 'IMPERIAL_MILE';

    /**
     * The length is measured in millimeters.
     */
    public const METRIC_MILLIMETER = 'METRIC_MILLIMETER';

    /**
     * The length is measured in centimeters.
     */
    public const METRIC_CENTIMETER = 'METRIC_CENTIMETER';

    /**
     * The length is measured in meters.
     */
    public const METRIC_METER = 'METRIC_METER';

    /**
     * The length is measured in kilometers.
     */
    public const METRIC_KILOMETER = 'METRIC_KILOMETER';
}
