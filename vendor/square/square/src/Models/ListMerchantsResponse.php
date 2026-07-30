<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The response object returned by the [ListMerchant]($e/Merchants/ListMerchants) endpoint.
 */
class ListMerchantsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Merchant[]|null
     */
    private $merchant;

    /**
     * @var int|null
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
     * Returns Merchant.
     * The requested `Merchant` entities.
     *
     * @return Merchant[]|null
     */
    public function getMerchant(): ?array
    {
        return $this->merchant;
    }

    /**
     * Sets Merchant.
     * The requested `Merchant` entities.
     *
     * @maps merchant
     *
     * @param Merchant[]|null $merchant
     */
    public function setMerchant(?array $merchant): void
    {
        $this->merchant = $merchant;
    }

    /**
     * Returns Cursor.
     * If the  response is truncated, the cursor to use in next  request to fetch next set of objects.
     */
    public function getCursor(): ?int
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * If the  response is truncated, the cursor to use in next  request to fetch next set of objects.
     *
     * @maps cursor
     */
    public function setCursor(?int $cursor): void
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
            $json['errors']   = $this->errors;
        }
        if (isset($this->merchant)) {
            $json['merchant'] = $this->merchant;
        }
        if (isset($this->cursor)) {
            $json['cursor']   = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
