<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines fields in a `ListDisputes` response.
 */
class ListDisputesResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Dispute[]|null
     */
    private $disputes;

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
     * Returns Disputes.
     * The list of disputes.
     *
     * @return Dispute[]|null
     */
    public function getDisputes(): ?array
    {
        return $this->disputes;
    }

    /**
     * Sets Disputes.
     * The list of disputes.
     *
     * @maps disputes
     *
     * @param Dispute[]|null $disputes
     */
    public function setDisputes(?array $disputes): void
    {
        $this->disputes = $disputes;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to be used in a subsequent request.
     * If unset, this is the final response. For more information, see [Pagination](https://developer.
     * squareup.com/docs/build-basics/common-api-patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in a subsequent request.
     * If unset, this is the final response. For more information, see [Pagination](https://developer.
     * squareup.com/docs/build-basics/common-api-patterns/pagination).
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
            $json['errors']   = $this->errors;
        }
        if (isset($this->disputes)) {
            $json['disputes'] = $this->disputes;
        }
        if (isset($this->cursor)) {
            $json['cursor']   = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
