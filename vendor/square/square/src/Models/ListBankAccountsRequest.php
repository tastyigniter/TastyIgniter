<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Request object for fetching all `BankAccount`
 * objects linked to a account.
 */
class ListBankAccountsRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $limit = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * Returns Cursor.
     * The pagination cursor returned by a previous call to this endpoint.
     * Use it in the next `ListBankAccounts` request to retrieve the next set
     * of results.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
     */
    public function getCursor(): ?string
    {
        if (count($this->cursor) == 0) {
            return null;
        }
        return $this->cursor['value'];
    }

    /**
     * Sets Cursor.
     * The pagination cursor returned by a previous call to this endpoint.
     * Use it in the next `ListBankAccounts` request to retrieve the next set
     * of results.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * The pagination cursor returned by a previous call to this endpoint.
     * Use it in the next `ListBankAccounts` request to retrieve the next set
     * of results.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Limit.
     * Upper limit on the number of bank accounts to return in the response.
     * Currently, 1000 is the largest supported limit. You can specify a limit
     * of up to 1000 bank accounts. This is also the default limit.
     */
    public function getLimit(): ?int
    {
        if (count($this->limit) == 0) {
            return null;
        }
        return $this->limit['value'];
    }

    /**
     * Sets Limit.
     * Upper limit on the number of bank accounts to return in the response.
     * Currently, 1000 is the largest supported limit. You can specify a limit
     * of up to 1000 bank accounts. This is also the default limit.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * Upper limit on the number of bank accounts to return in the response.
     * Currently, 1000 is the largest supported limit. You can specify a limit
     * of up to 1000 bank accounts. This is also the default limit.
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
    }

    /**
     * Returns Location Id.
     * Location ID. You can specify this optional filter
     * to retrieve only the linked bank accounts belonging to a specific location.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * Location ID. You can specify this optional filter
     * to retrieve only the linked bank accounts belonging to a specific location.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * Location ID. You can specify this optional filter
     * to retrieve only the linked bank accounts belonging to a specific location.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
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
        if (!empty($this->cursor)) {
            $json['cursor']      = $this->cursor['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']       = $this->limit['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id'] = $this->locationId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
