<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CatalogInfoResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CatalogInfoResponseLimits|null
     */
    private $limits;

    /**
     * @var StandardUnitDescriptionGroup|null
     */
    private $standardUnitDescriptionGroup;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Limits.
     */
    public function getLimits(): ?CatalogInfoResponseLimits
    {
        return $this->limits;
    }

    /**
     * Sets Limits.
     *
     * @maps limits
     */
    public function setLimits(?CatalogInfoResponseLimits $limits): void
    {
        $this->limits = $limits;
    }

    /**
     * Returns Standard Unit Description Group.
     * Group of standard measurement units.
     */
    public function getStandardUnitDescriptionGroup(): ?StandardUnitDescriptionGroup
    {
        return $this->standardUnitDescriptionGroup;
    }

    /**
     * Sets Standard Unit Description Group.
     * Group of standard measurement units.
     *
     * @maps standard_unit_description_group
     */
    public function setStandardUnitDescriptionGroup(?StandardUnitDescriptionGroup $standardUnitDescriptionGroup): void
    {
        $this->standardUnitDescriptionGroup = $standardUnitDescriptionGroup;
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
        if (isset($this->errors)) {
            $json['errors']                          = $this->errors;
        }
        if (isset($this->limits)) {
            $json['limits']                          = $this->limits;
        }
        if (isset($this->standardUnitDescriptionGroup)) {
            $json['standard_unit_description_group'] = $this->standardUnitDescriptionGroup;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
