<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The information needed to define a custom unit, provided by the seller.
 */
class MeasurementUnitCustom implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $abbreviation;

    /**
     * @param string $name
     * @param string $abbreviation
     */
    public function __construct(string $name, string $abbreviation)
    {
        $this->name = $name;
        $this->abbreviation = $abbreviation;
    }

    /**
     * Returns Name.
     * The name of the custom unit, for example "bushel".
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     * The name of the custom unit, for example "bushel".
     *
     * @required
     * @maps name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Abbreviation.
     * The abbreviation of the custom unit, such as "bsh" (bushel). This appears
     * in the cart for the Point of Sale app, and in reports.
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * Sets Abbreviation.
     * The abbreviation of the custom unit, such as "bsh" (bushel). This appears
     * in the cart for the Point of Sale app, and in reports.
     *
     * @required
     * @maps abbreviation
     */
    public function setAbbreviation(string $abbreviation): void
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        $json['name']         = $this->name;
        $json['abbreviation'] = $this->abbreviation;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
