<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Response object returned by ListBankAccounts.
 */
class ListBankAccountsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var BankAccount[]|null
     */
    private $bankAccounts;

    /**
     * @var string|null
     */
    private $cursor;

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
     * Returns Bank Accounts.
     * List of BankAccounts associated with this account.
     *
     * @return BankAccount[]|null
     */
    public function getBankAccounts(): ?array
    {
        return $this->bankAccounts;
    }

    /**
     * Sets Bank Accounts.
     * List of BankAccounts associated with this account.
     *
     * @maps bank_accounts
     *
     * @param BankAccount[]|null $bankAccounts
     */
    public function setBankAccounts(?array $bankAccounts): void
    {
        $this->bankAccounts = $bankAccounts;
    }

    /**
     * Returns Cursor.
     * When a response is truncated, it includes a cursor that you can
     * use in a subsequent request to fetch next set of bank accounts.
     * If empty, this is the final response.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * When a response is truncated, it includes a cursor that you can
     * use in a subsequent request to fetch next set of bank accounts.
     * If empty, this is the final response.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
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
            $json['errors']        = $this->errors;
        }
        if (isset($this->bankAccounts)) {
            $json['bank_accounts'] = $this->bankAccounts;
        }
        if (isset($this->cursor)) {
            $json['cursor']        = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
