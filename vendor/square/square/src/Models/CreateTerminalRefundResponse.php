<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CreateTerminalRefundResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var TerminalRefund|null
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
     * Represents a payment refund processed by the Square Terminal. Only supports Interac (Canadian debit
     * network) payment refunds.
     */
    public function getRefund(): ?TerminalRefund
    {
        return $this->refund;
    }

    /**
     * Sets Refund.
     * Represents a payment refund processed by the Square Terminal. Only supports Interac (Canadian debit
     * network) payment refunds.
     *
     * @maps refund
     */
    public function setRefund(?TerminalRefund $refund): void
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
