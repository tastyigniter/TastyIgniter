<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class RetrieveCashDrawerShiftResponse implements \JsonSerializable
{
    /**
     * @var CashDrawerShift|null
     */
    private $cashDrawerShift;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Cash Drawer Shift.
     * This model gives the details of a cash drawer shift.
     * The cash_payment_money, cash_refund_money, cash_paid_in_money,
     * and cash_paid_out_money fields are all computed by summing their respective
     * event types.
     */
    public function getCashDrawerShift(): ?CashDrawerShift
    {
        return $this->cashDrawerShift;
    }

    /**
     * Sets Cash Drawer Shift.
     * This model gives the details of a cash drawer shift.
     * The cash_payment_money, cash_refund_money, cash_paid_in_money,
     * and cash_paid_out_money fields are all computed by summing their respective
     * event types.
     *
     * @maps cash_drawer_shift
     */
    public function setCashDrawerShift(?CashDrawerShift $cashDrawerShift): void
    {
        $this->cashDrawerShift = $cashDrawerShift;
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
        if (isset($this->cashDrawerShift)) {
            $json['cash_drawer_shift'] = $this->cashDrawerShift;
        }
        if (isset($this->errors)) {
            $json['errors']            = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
