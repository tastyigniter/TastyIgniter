<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an update request for the `WageSetting` object describing a `TeamMember`.
 */
class UpdateWageSettingRequest implements \JsonSerializable
{
    /**
     * @var WageSetting
     */
    private $wageSetting;

    /**
     * @param WageSetting $wageSetting
     */
    public function __construct(WageSetting $wageSetting)
    {
        $this->wageSetting = $wageSetting;
    }

    /**
     * Returns Wage Setting.
     * An object representing a team member's wage information.
     */
    public function getWageSetting(): WageSetting
    {
        return $this->wageSetting;
    }

    /**
     * Sets Wage Setting.
     * An object representing a team member's wage information.
     *
     * @required
     * @maps wage_setting
     */
    public function setWageSetting(WageSetting $wageSetting): void
    {
        $this->wageSetting = $wageSetting;
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
        $json['wage_setting'] = $this->wageSetting;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
