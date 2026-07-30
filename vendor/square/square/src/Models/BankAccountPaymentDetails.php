<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Additional details about BANK_ACCOUNT type payments.
 */
class BankAccountPaymentDetails implements \JsonSerializable
{
    /**
     * @var array
     */
    private $bankName = [];

    /**
     * @var array
     */
    private $transferType = [];

    /**
     * @var array
     */
    private $accountOwnershipType = [];

    /**
     * @var array
     */
    private $fingerprint = [];

    /**
     * @var array
     */
    private $country = [];

    /**
     * @var array
     */
    private $statementDescription = [];

    /**
     * @var ACHDetails|null
     */
    private $achDetails;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * Returns Bank Name.
     * The name of the bank associated with the bank account.
     */
    public function getBankName(): ?string
    {
        if (count($this->bankName) == 0) {
            return null;
        }
        return $this->bankName['value'];
    }

    /**
     * Sets Bank Name.
     * The name of the bank associated with the bank account.
     *
     * @maps bank_name
     */
    public function setBankName(?string $bankName): void
    {
        $this->bankName['value'] = $bankName;
    }

    /**
     * Unsets Bank Name.
     * The name of the bank associated with the bank account.
     */
    public function unsetBankName(): void
    {
        $this->bankName = [];
    }

    /**
     * Returns Transfer Type.
     * The type of the bank transfer. The type can be `ACH` or `UNKNOWN`.
     */
    public function getTransferType(): ?string
    {
        if (count($this->transferType) == 0) {
            return null;
        }
        return $this->transferType['value'];
    }

    /**
     * Sets Transfer Type.
     * The type of the bank transfer. The type can be `ACH` or `UNKNOWN`.
     *
     * @maps transfer_type
     */
    public function setTransferType(?string $transferType): void
    {
        $this->transferType['value'] = $transferType;
    }

    /**
     * Unsets Transfer Type.
     * The type of the bank transfer. The type can be `ACH` or `UNKNOWN`.
     */
    public function unsetTransferType(): void
    {
        $this->transferType = [];
    }

    /**
     * Returns Account Ownership Type.
     * The ownership type of the bank account performing the transfer.
     * The type can be `INDIVIDUAL`, `COMPANY`, or `ACCOUNT_TYPE_UNKNOWN`.
     */
    public function getAccountOwnershipType(): ?string
    {
        if (count($this->accountOwnershipType) == 0) {
            return null;
        }
        return $this->accountOwnershipType['value'];
    }

    /**
     * Sets Account Ownership Type.
     * The ownership type of the bank account performing the transfer.
     * The type can be `INDIVIDUAL`, `COMPANY`, or `ACCOUNT_TYPE_UNKNOWN`.
     *
     * @maps account_ownership_type
     */
    public function setAccountOwnershipType(?string $accountOwnershipType): void
    {
        $this->accountOwnershipType['value'] = $accountOwnershipType;
    }

    /**
     * Unsets Account Ownership Type.
     * The ownership type of the bank account performing the transfer.
     * The type can be `INDIVIDUAL`, `COMPANY`, or `ACCOUNT_TYPE_UNKNOWN`.
     */
    public function unsetAccountOwnershipType(): void
    {
        $this->accountOwnershipType = [];
    }

    /**
     * Returns Fingerprint.
     * Uniquely identifies the bank account for this seller and can be used
     * to determine if payments are from the same bank account.
     */
    public function getFingerprint(): ?string
    {
        if (count($this->fingerprint) == 0) {
            return null;
        }
        return $this->fingerprint['value'];
    }

    /**
     * Sets Fingerprint.
     * Uniquely identifies the bank account for this seller and can be used
     * to determine if payments are from the same bank account.
     *
     * @maps fingerprint
     */
    public function setFingerprint(?string $fingerprint): void
    {
        $this->fingerprint['value'] = $fingerprint;
    }

    /**
     * Unsets Fingerprint.
     * Uniquely identifies the bank account for this seller and can be used
     * to determine if payments are from the same bank account.
     */
    public function unsetFingerprint(): void
    {
        $this->fingerprint = [];
    }

    /**
     * Returns Country.
     * The two-letter ISO code representing the country the bank account is located in.
     */
    public function getCountry(): ?string
    {
        if (count($this->country) == 0) {
            return null;
        }
        return $this->country['value'];
    }

    /**
     * Sets Country.
     * The two-letter ISO code representing the country the bank account is located in.
     *
     * @maps country
     */
    public function setCountry(?string $country): void
    {
        $this->country['value'] = $country;
    }

    /**
     * Unsets Country.
     * The two-letter ISO code representing the country the bank account is located in.
     */
    public function unsetCountry(): void
    {
        $this->country = [];
    }

    /**
     * Returns Statement Description.
     * The statement description as sent to the bank.
     */
    public function getStatementDescription(): ?string
    {
        if (count($this->statementDescription) == 0) {
            return null;
        }
        return $this->statementDescription['value'];
    }

    /**
     * Sets Statement Description.
     * The statement description as sent to the bank.
     *
     * @maps statement_description
     */
    public function setStatementDescription(?string $statementDescription): void
    {
        $this->statementDescription['value'] = $statementDescription;
    }

    /**
     * Unsets Statement Description.
     * The statement description as sent to the bank.
     */
    public function unsetStatementDescription(): void
    {
        $this->statementDescription = [];
    }

    /**
     * Returns Ach Details.
     * ACH-specific details about `BANK_ACCOUNT` type payments with the `transfer_type` of `ACH`.
     */
    public function getAchDetails(): ?ACHDetails
    {
        return $this->achDetails;
    }

    /**
     * Sets Ach Details.
     * ACH-specific details about `BANK_ACCOUNT` type payments with the `transfer_type` of `ACH`.
     *
     * @maps ach_details
     */
    public function setAchDetails(?ACHDetails $achDetails): void
    {
        $this->achDetails = $achDetails;
    }

    /**
     * Returns Errors.
     * Information about errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        if (count($this->errors) == 0) {
            return null;
        }
        return $this->errors['value'];
    }

    /**
     * Sets Errors.
     * Information about errors encountered during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors['value'] = $errors;
    }

    /**
     * Unsets Errors.
     * Information about errors encountered during the request.
     */
    public function unsetErrors(): void
    {
        $this->errors = [];
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
        if (!empty($this->bankName)) {
            $json['bank_name']              = $this->bankName['value'];
        }
        if (!empty($this->transferType)) {
            $json['transfer_type']          = $this->transferType['value'];
        }
        if (!empty($this->accountOwnershipType)) {
            $json['account_ownership_type'] = $this->accountOwnershipType['value'];
        }
        if (!empty($this->fingerprint)) {
            $json['fingerprint']            = $this->fingerprint['value'];
        }
        if (!empty($this->country)) {
            $json['country']                = $this->country['value'];
        }
        if (!empty($this->statementDescription)) {
            $json['statement_description']  = $this->statementDescription['value'];
        }
        if (isset($this->achDetails)) {
            $json['ach_details']            = $this->achDetails;
        }
        if (!empty($this->errors)) {
            $json['errors']                 = $this->errors['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
