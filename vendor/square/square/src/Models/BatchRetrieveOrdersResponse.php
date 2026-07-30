<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the `BatchRetrieveOrders` endpoint.
 */
class BatchRetrieveOrdersResponse implements \JsonSerializable
{
    /**
     * @var Order[]|null
     */
    private $orders;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Orders.
     * The requested orders. This will omit any requested orders that do not exist.
     *
     * @return Order[]|null
     */
    public function getOrders(): ?array
    {
        return $this->orders;
    }

    /**
     * Sets Orders.
     * The requested orders. This will omit any requested orders that do not exist.
     *
     * @maps orders
     *
     * @param Order[]|null $orders
     */
    public function setOrders(?array $orders): void
    {
        $this->orders = $orders;
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
        if (isset($this->orders)) {
            $json['orders'] = $this->orders;
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
