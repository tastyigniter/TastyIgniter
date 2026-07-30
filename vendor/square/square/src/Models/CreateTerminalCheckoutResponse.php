<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CreateTerminalCheckoutResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var TerminalCheckout|null
     */
    private $checkout;

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
     * Returns Checkout.
     * Represents a checkout processed by the Square Terminal.
     */
    public function getCheckout(): ?TerminalCheckout
    {
        return $this->checkout;
    }

    /**
     * Sets Checkout.
     * Represents a checkout processed by the Square Terminal.
     *
     * @maps checkout
     */
    public function setCheckout(?TerminalCheckout $checkout): void
    {
        $this->checkout = $checkout;
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
        if (isset($this->checkout)) {
            $json['checkout'] = $this->checkout;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
