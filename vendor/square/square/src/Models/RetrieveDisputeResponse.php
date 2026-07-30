<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines fields in a `RetrieveDispute` response.
 */
class RetrieveDisputeResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Dispute|null
     */
    private $dispute;

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
     * Returns Dispute.
     * Represents a [dispute](https://developer.squareup.com/docs/disputes-api/overview) a cardholder
     * initiated with their bank.
     */
    public function getDispute(): ?Dispute
    {
        return $this->dispute;
    }

    /**
     * Sets Dispute.
     * Represents a [dispute](https://developer.squareup.com/docs/disputes-api/overview) a cardholder
     * initiated with their bank.
     *
     * @maps dispute
     */
    public function setDispute(?Dispute $dispute): void
    {
        $this->dispute = $dispute;
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
        if (isset($this->dispute)) {
            $json['dispute'] = $this->dispute;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
