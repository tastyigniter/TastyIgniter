<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class V1ListOrdersResponse implements \JsonSerializable
{
    /**
     * @var V1Order[]|null
     */
    private $items;

    /**
     * Returns Items.
     *
     * @return V1Order[]|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Sets Items.
     *
     * @maps items
     *
     * @param V1Order[]|null $items
     */
    public function setItems(?array $items): void
    {
        $this->items = $items;
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
        if (isset($this->items)) {
            $json['items'] = $this->items;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
