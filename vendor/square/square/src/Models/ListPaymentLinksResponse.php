<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListPaymentLinksResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var PaymentLink[]|null
     */
    private $paymentLinks;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * Returns Errors.
     * Errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Errors that occurred during the request.
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
     * Returns Payment Links.
     * The list of payment links.
     *
     * @return PaymentLink[]|null
     */
    public function getPaymentLinks(): ?array
    {
        return $this->paymentLinks;
    }

    /**
     * Sets Payment Links.
     * The list of payment links.
     *
     * @maps payment_links
     *
     * @param PaymentLink[]|null $paymentLinks
     */
    public function setPaymentLinks(?array $paymentLinks): void
    {
        $this->paymentLinks = $paymentLinks;
    }

    /**
     * Returns Cursor.
     * When a response is truncated, it includes a cursor that you can use in a subsequent request
     * to retrieve the next set of gift cards. If a cursor is not present, this is the final response.
     * For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * When a response is truncated, it includes a cursor that you can use in a subsequent request
     * to retrieve the next set of gift cards. If a cursor is not present, this is the final response.
     * For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination).
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
        if (isset($this->paymentLinks)) {
            $json['payment_links'] = $this->paymentLinks;
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
