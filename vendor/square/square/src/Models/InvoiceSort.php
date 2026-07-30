<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Identifies the sort field and sort order.
 */
class InvoiceSort implements \JsonSerializable
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string|null
     */
    private $order;

    /**
     * Returns Field.
     * The field to use for sorting.
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * Sets Field.
     * The field to use for sorting.
     *
     * @maps field
     */
    public function setField(string $field): void
    {
        $this->field = $field;
    }

    /**
     * Returns Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * Sets Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     *
     * @maps order
     */
    public function setOrder(?string $order): void
    {
        $this->order = $order;
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
        $json['field']     = $this->field;
        if (isset($this->order)) {
            $json['order'] = $this->order;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
