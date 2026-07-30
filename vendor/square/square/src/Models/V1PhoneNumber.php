<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a phone number.
 */
class V1PhoneNumber implements \JsonSerializable
{
    /**
     * @var string
     */
    private $callingCode;

    /**
     * @var string
     */
    private $number;

    /**
     * @param string $callingCode
     * @param string $number
     */
    public function __construct(string $callingCode, string $number)
    {
        $this->callingCode = $callingCode;
        $this->number = $number;
    }

    /**
     * Returns Calling Code.
     * The phone number's international calling code. For US phone numbers, this value is +1.
     */
    public function getCallingCode(): string
    {
        return $this->callingCode;
    }

    /**
     * Sets Calling Code.
     * The phone number's international calling code. For US phone numbers, this value is +1.
     *
     * @required
     * @maps calling_code
     */
    public function setCallingCode(string $callingCode): void
    {
        $this->callingCode = $callingCode;
    }

    /**
     * Returns Number.
     * The phone number.
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Sets Number.
     * The phone number.
     *
     * @required
     * @maps number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
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
        $json['calling_code'] = $this->callingCode;
        $json['number']       = $this->number;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
