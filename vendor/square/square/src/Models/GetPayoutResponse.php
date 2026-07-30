<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class GetPayoutResponse implements \JsonSerializable
{
    /**
     * @var Payout|null
     */
    private $payout;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Payout.
     * An accounting of the amount owed the seller and record of the actual transfer to their
     * external bank account or to the Square balance.
     */
    public function getPayout(): ?Payout
    {
        return $this->payout;
    }

    /**
     * Sets Payout.
     * An accounting of the amount owed the seller and record of the actual transfer to their
     * external bank account or to the Square balance.
     *
     * @maps payout
     */
    public function setPayout(?Payout $payout): void
    {
        $this->payout = $payout;
    }

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
        if (isset($this->payout)) {
            $json['payout'] = $this->payout;
        }
        if (isset($this->errors)) {
            $json['errors'] = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
