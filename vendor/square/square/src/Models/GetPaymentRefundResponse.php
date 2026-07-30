<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the response returned by [GetRefund]($e/Refunds/GetPaymentRefund).
 *
 * Note: If there are errors processing the request, the refund field might not be
 * present or it might be present in a FAILED state.
 */
class GetPaymentRefundResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var PaymentRefund|null
     */
    private $refund;

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
     * Returns Refund.
     * Represents a refund of a payment made using Square. Contains information about
     * the original payment and the amount of money refunded.
     */
    public function getRefund(): ?PaymentRefund
    {
        return $this->refund;
    }

    /**
     * Sets Refund.
     * Represents a refund of a payment made using Square. Contains information about
     * the original payment and the amount of money refunded.
     *
     * @maps refund
     */
    public function setRefund(?PaymentRefund $refund): void
    {
        $this->refund = $refund;
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
            $json['errors'] = $this->errors;
        }
        if (isset($this->refund)) {
            $json['refund'] = $this->refund;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
