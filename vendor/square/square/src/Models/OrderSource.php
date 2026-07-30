<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the origination details of an order.
 */
class OrderSource implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * Returns Name.
     * The name used to identify the place (physical or digital) that an order originates.
     * If unset, the name defaults to the name of the application that created the order.
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * The name used to identify the place (physical or digital) that an order originates.
     * If unset, the name defaults to the name of the application that created the order.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name used to identify the place (physical or digital) that an order originates.
     * If unset, the name defaults to the name of the application that created the order.
     */
    public function unsetName(): void
    {
        $this->name = [];
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
        if (!empty($this->name)) {
            $json['name'] = $this->name['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
