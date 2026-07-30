<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * ACH-specific details about `BANK_ACCOUNT` type payments with the `transfer_type` of `ACH`.
 */
class ACHDetails implements \JsonSerializable
{
    /**
     * @var array
     */
    private $routingNumber = [];

    /**
     * @var array
     */
    private $accountNumberSuffix = [];

    /**
     * @var array
     */
    private $accountType = [];

    /**
     * Returns Routing Number.
     * The routing number for the bank account.
     */
    public function getRoutingNumber(): ?string
    {
        if (count($this->routingNumber) == 0) {
            return null;
        }
        return $this->routingNumber['value'];
    }

    /**
     * Sets Routing Number.
     * The routing number for the bank account.
     *
     * @maps routing_number
     */
    public function setRoutingNumber(?string $routingNumber): void
    {
        $this->routingNumber['value'] = $routingNumber;
    }

    /**
     * Unsets Routing Number.
     * The routing number for the bank account.
     */
    public function unsetRoutingNumber(): void
    {
        $this->routingNumber = [];
    }

    /**
     * Returns Account Number Suffix.
     * The last few digits of the bank account number.
     */
    public function getAccountNumberSuffix(): ?string
    {
        if (count($this->accountNumberSuffix) == 0) {
            return null;
        }
        return $this->accountNumberSuffix['value'];
    }

    /**
     * Sets Account Number Suffix.
     * The last few digits of the bank account number.
     *
     * @maps account_number_suffix
     */
    public function setAccountNumberSuffix(?string $accountNumberSuffix): void
    {
        $this->accountNumberSuffix['value'] = $accountNumberSuffix;
    }

    /**
     * Unsets Account Number Suffix.
     * The last few digits of the bank account number.
     */
    public function unsetAccountNumberSuffix(): void
    {
        $this->accountNumberSuffix = [];
    }

    /**
     * Returns Account Type.
     * The type of the bank account performing the transfer. The account type can be `CHECKING`,
     * `SAVINGS`, or `UNKNOWN`.
     */
    public function getAccountType(): ?string
    {
        if (count($this->accountType) == 0) {
            return null;
        }
        return $this->accountType['value'];
    }

    /**
     * Sets Account Type.
     * The type of the bank account performing the transfer. The account type can be `CHECKING`,
     * `SAVINGS`, or `UNKNOWN`.
     *
     * @maps account_type
     */
    public function setAccountType(?string $accountType): void
    {
        $this->accountType['value'] = $accountType;
    }

    /**
     * Unsets Account Type.
     * The type of the bank account performing the transfer. The account type can be `CHECKING`,
     * `SAVINGS`, or `UNKNOWN`.
     */
    public function unsetAccountType(): void
    {
        $this->accountType = [];
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
        if (!empty($this->routingNumber)) {
            $json['routing_number']        = $this->routingNumber['value'];
        }
        if (!empty($this->accountNumberSuffix)) {
            $json['account_number_suffix'] = $this->accountNumberSuffix['value'];
        }
        if (!empty($this->accountType)) {
            $json['account_type']          = $this->accountType['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
