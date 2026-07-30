<?php

declare(strict_types=1);

namespace Square\Models;

use Square\ApiHelper;
use stdClass;

class SquareEventData implements \JsonSerializable
{
    /**
     * @var array
     */
    private $type = [];

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $deleted = [];

    /**
     * @var array
     */
    private $object = [];

    /**
     * Returns Type.
     * Name of the affected object’s type.
     */
    public function getType(): ?string
    {
        if (count($this->type) == 0) {
            return null;
        }
        return $this->type['value'];
    }

    /**
     * Sets Type.
     * Name of the affected object’s type.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type['value'] = $type;
    }

    /**
     * Unsets Type.
     * Name of the affected object’s type.
     */
    public function unsetType(): void
    {
        $this->type = [];
    }

    /**
     * Returns Id.
     * ID of the affected object.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * ID of the affected object.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Deleted.
     * Is true if the affected object was deleted. Otherwise absent.
     */
    public function getDeleted(): ?bool
    {
        if (count($this->deleted) == 0) {
            return null;
        }
        return $this->deleted['value'];
    }

    /**
     * Sets Deleted.
     * Is true if the affected object was deleted. Otherwise absent.
     *
     * @maps deleted
     */
    public function setDeleted(?bool $deleted): void
    {
        $this->deleted['value'] = $deleted;
    }

    /**
     * Unsets Deleted.
     * Is true if the affected object was deleted. Otherwise absent.
     */
    public function unsetDeleted(): void
    {
        $this->deleted = [];
    }

    /**
     * Returns Object.
     * An object containing fields and values relevant to the event. Is absent if affected object was
     * deleted.
     *
     * @return mixed
     */
    public function getObject()
    {
        if (count($this->object) == 0) {
            return null;
        }
        return $this->object['value'];
    }

    /**
     * Sets Object.
     * An object containing fields and values relevant to the event. Is absent if affected object was
     * deleted.
     *
     * @maps object
     *
     * @param mixed $object
     */
    public function setObject($object): void
    {
        $this->object['value'] = $object;
    }

    /**
     * Unsets Object.
     * An object containing fields and values relevant to the event. Is absent if affected object was
     * deleted.
     */
    public function unsetObject(): void
    {
        $this->object = [];
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
        if (!empty($this->type)) {
            $json['type']    = $this->type['value'];
        }
        if (isset($this->id)) {
            $json['id']      = $this->id;
        }
        if (!empty($this->deleted)) {
            $json['deleted'] = $this->deleted['value'];
        }
        if (!empty($this->object)) {
            $json['object']  = ApiHelper::decodeJson($this->object['value'], 'object');
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
