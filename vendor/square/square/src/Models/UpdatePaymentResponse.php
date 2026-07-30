<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the response returned by
 * [UpdatePayment]($e/Payments/UpdatePayment).
 */
class UpdatePaymentResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Payment|null
     */
    private $payment;

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
     * Returns Payment.
     * Represents a payment processed by the Square API.
     */
    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    /**
     * Sets Payment.
     * Represents a payment processed by the Square API.
     *
     * @maps payment
     */
    public function setPayment(?Payment $payment): void
    {
        $this->payment = $payment;
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
        if (isset($this->payment)) {
            $json['payment'] = $this->payment;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
