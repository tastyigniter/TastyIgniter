<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the response returned by [ListPaymentRefunds]($e/Refunds/ListPaymentRefunds).
 *
 * Either `errors` or `refunds` is present in a given response (never both).
 */
class ListPaymentRefundsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var PaymentRefund[]|null
     */
    private $refunds;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * Returns Errors.
     * Information about errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
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
        $this->errors = $errors;
    }

    /**
     * Returns Refunds.
     * The list of requested refunds.
     *
     * @return PaymentRefund[]|null
     */
    public function getRefunds(): ?array
    {
        return $this->refunds;
    }

    /**
     * Sets Refunds.
     * The list of requested refunds.
     *
     * @maps refunds
     *
     * @param PaymentRefund[]|null $refunds
     */
    public function setRefunds(?array $refunds): void
    {
        $this->refunds = $refunds;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to be used in a subsequent request. If empty,
     * this is the final response.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in a subsequent request. If empty,
     * this is the final response.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
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
            $json['errors']  = $this->errors;
        }
        if (isset($this->refunds)) {
            $json['refunds'] = $this->refunds;
        }
        if (isset($this->cursor)) {
            $json['cursor']  = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
