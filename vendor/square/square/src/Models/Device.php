<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class Device implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $name = [];

    /**
     * Returns Id.
     * The device's Square-issued ID.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The device's Square-issued ID.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Name.
     * The device's merchant-specified name.
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
     * The device's merchant-specified name.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The device's merchant-specified name.
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
        if (isset($this->id)) {
            $json['id']   = $this->id;
        }
        if (!empty($this->name)) {
            $json['name'] = $this->name['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
