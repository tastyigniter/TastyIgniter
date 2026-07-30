<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the `CreateCheckout` endpoint.
 */
class CreateCheckoutResponse implements \JsonSerializable
{
    /**
     * @var Checkout|null
     */
    private $checkout;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Checkout.
     * Square Checkout lets merchants accept online payments for supported
     * payment types using a checkout workflow hosted on squareup.com.
     */
    public function getCheckout(): ?Checkout
    {
        return $this->checkout;
    }

    /**
     * Sets Checkout.
     * Square Checkout lets merchants accept online payments for supported
     * payment types using a checkout workflow hosted on squareup.com.
     *
     * @maps checkout
     */
    public function setCheckout(?Checkout $checkout): void
    {
        $this->checkout = $checkout;
    }

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
        if (isset($this->checkout)) {
            $json['checkout'] = $this->checkout;
        }
        if (isset($this->errors)) {
            $json['errors']   = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
