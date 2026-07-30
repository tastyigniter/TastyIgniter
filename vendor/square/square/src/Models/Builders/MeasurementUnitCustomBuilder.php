<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\MeasurementUnitCustom;

/**
 * Builder for model MeasurementUnitCustom
 *
 * @see MeasurementUnitCustom
 */
class MeasurementUnitCustomBuilder
{
    /**
     * @var MeasurementUnitCustom
     */
    private $instance;

    private function __construct(MeasurementUnitCustom $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new measurement unit custom Builder object.
     */
    public static function init(string $name, string $abbreviation): self
    {
        return new self(new MeasurementUnitCustom($name, $abbreviation));
    }

    /**
     * Initializes a new measurement unit custom object.
     */
    public function build(): MeasurementUnitCustom
    {
        return CoreHelper::clone($this->instance);
    }
}
