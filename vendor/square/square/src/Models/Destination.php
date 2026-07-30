<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Information about the destination against which the payout was made.
 */
class Destination implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $id;

    /**
     * Returns Type.
     * List of possible destinations against which a payout can be made.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * List of possible destinations against which a payout can be made.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Id.
     * Square issued unique ID (also known as the instrument ID) associated with this destination.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * Square issued unique ID (also known as the instrument ID) associated with this destination.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
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
        if (isset($this->type)) {
            $json['type'] = $this->type;
        }
        if (isset($this->id)) {
            $json['id']   = $this->id;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
