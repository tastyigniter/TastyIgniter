<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response that includes loyalty accounts that satisfy the search criteria.
 */
class SearchLoyaltyAccountsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var LoyaltyAccount[]|null
     */
    private $loyaltyAccounts;

    /**
     * @var string|null
     */
    private $cursor;

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
     * Returns Loyalty Accounts.
     * The loyalty accounts that met the search criteria,
     * in order of creation date.
     *
     * @return LoyaltyAccount[]|null
     */
    public function getLoyaltyAccounts(): ?array
    {
        return $this->loyaltyAccounts;
    }

    /**
     * Sets Loyalty Accounts.
     * The loyalty accounts that met the search criteria,
     * in order of creation date.
     *
     * @maps loyalty_accounts
     *
     * @param LoyaltyAccount[]|null $loyaltyAccounts
     */
    public function setLoyaltyAccounts(?array $loyaltyAccounts): void
    {
        $this->loyaltyAccounts = $loyaltyAccounts;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to use in a subsequent
     * request. If empty, this is the final response.
     * For more information,
     * see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to use in a subsequent
     * request. If empty, this is the final response.
     * For more information,
     * see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).
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
            $json['errors']           = $this->errors;
        }
        if (isset($this->loyaltyAccounts)) {
            $json['loyalty_accounts'] = $this->loyaltyAccounts;
        }
        if (isset($this->cursor)) {
            $json['cursor']           = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
