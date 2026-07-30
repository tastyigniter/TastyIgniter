<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Response object returned by `GetBankAccount`.
 */
class GetBankAccountResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var BankAccount|null
     */
    private $bankAccount;

    /**
     * Returns Errors.
     * Information on errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Information on errors encountered during the request.
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
     * Returns Bank Account.
     * Represents a bank account. For more information about
     * linking a bank account to a Square account, see
     * [Bank Accounts API](https://developer.squareup.com/docs/bank-accounts-api).
     */
    public function getBankAccount(): ?BankAccount
    {
        return $this->bankAccount;
    }

    /**
     * Sets Bank Account.
     * Represents a bank account. For more information about
     * linking a bank account to a Square account, see
     * [Bank Accounts API](https://developer.squareup.com/docs/bank-accounts-api).
     *
     * @maps bank_account
     */
    public function setBankAccount(?BankAccount $bankAccount): void
    {
        $this->bankAccount = $bankAccount;
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
            $json['errors']       = $this->errors;
        }
        if (isset($this->bankAccount)) {
            $json['bank_account'] = $this->bankAccount;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
