<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response that contains all loyalty programs.
 */
class ListLoyaltyProgramsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var LoyaltyProgram[]|null
     */
    private $programs;

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
     * Returns Programs.
     * A list of `LoyaltyProgram` for the merchant.
     *
     * @return LoyaltyProgram[]|null
     */
    public function getPrograms(): ?array
    {
        return $this->programs;
    }

    /**
     * Sets Programs.
     * A list of `LoyaltyProgram` for the merchant.
     *
     * @maps programs
     *
     * @param LoyaltyProgram[]|null $programs
     */
    public function setPrograms(?array $programs): void
    {
        $this->programs = $programs;
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
            $json['errors']   = $this->errors;
        }
        if (isset($this->programs)) {
            $json['programs'] = $this->programs;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
