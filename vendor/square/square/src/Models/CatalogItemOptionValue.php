<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * An enumerated value that can link a
 * `CatalogItemVariation` to an item option as one of
 * its item option values.
 */
class CatalogItemOptionValue implements \JsonSerializable
{
    /**
     * @var array
     */
    private $itemOptionId = [];

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $description = [];

    /**
     * @var array
     */
    private $color = [];

    /**
     * @var array
     */
    private $ordinal = [];

    /**
     * Returns Item Option Id.
     * Unique ID of the associated item option.
     */
    public function getItemOptionId(): ?string
    {
        if (count($this->itemOptionId) == 0) {
            return null;
        }
        return $this->itemOptionId['value'];
    }

    /**
     * Sets Item Option Id.
     * Unique ID of the associated item option.
     *
     * @maps item_option_id
     */
    public function setItemOptionId(?string $itemOptionId): void
    {
        $this->itemOptionId['value'] = $itemOptionId;
    }

    /**
     * Unsets Item Option Id.
     * Unique ID of the associated item option.
     */
    public function unsetItemOptionId(): void
    {
        $this->itemOptionId = [];
    }

    /**
     * Returns Name.
     * Name of this item option value. This is a searchable attribute for use in applicable query filters.
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
     * Name of this item option value. This is a searchable attribute for use in applicable query filters.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * Name of this item option value. This is a searchable attribute for use in applicable query filters.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Description.
     * A human-readable description for the option value. This is a searchable attribute for use in
     * applicable query filters.
     */
    public function getDescription(): ?string
    {
        if (count($this->description) == 0) {
            return null;
        }
        return $this->description['value'];
    }

    /**
     * Sets Description.
     * A human-readable description for the option value. This is a searchable attribute for use in
     * applicable query filters.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description['value'] = $description;
    }

    /**
     * Unsets Description.
     * A human-readable description for the option value. This is a searchable attribute for use in
     * applicable query filters.
     */
    public function unsetDescription(): void
    {
        $this->description = [];
    }

    /**
     * Returns Color.
     * The HTML-supported hex color for the item option (e.g., "#ff8d4e85").
     * Only displayed if `show_colors` is enabled on the parent `ItemOption`. When
     * left unset, `color` defaults to white ("#ffffff") when `show_colors` is
     * enabled on the parent `ItemOption`.
     */
    public function getColor(): ?string
    {
        if (count($this->color) == 0) {
            return null;
        }
        return $this->color['value'];
    }

    /**
     * Sets Color.
     * The HTML-supported hex color for the item option (e.g., "#ff8d4e85").
     * Only displayed if `show_colors` is enabled on the parent `ItemOption`. When
     * left unset, `color` defaults to white ("#ffffff") when `show_colors` is
     * enabled on the parent `ItemOption`.
     *
     * @maps color
     */
    public function setColor(?string $color): void
    {
        $this->color['value'] = $color;
    }

    /**
     * Unsets Color.
     * The HTML-supported hex color for the item option (e.g., "#ff8d4e85").
     * Only displayed if `show_colors` is enabled on the parent `ItemOption`. When
     * left unset, `color` defaults to white ("#ffffff") when `show_colors` is
     * enabled on the parent `ItemOption`.
     */
    public function unsetColor(): void
    {
        $this->color = [];
    }

    /**
     * Returns Ordinal.
     * Determines where this option value appears in a list of option values.
     */
    public function getOrdinal(): ?int
    {
        if (count($this->ordinal) == 0) {
            return null;
        }
        return $this->ordinal['value'];
    }

    /**
     * Sets Ordinal.
     * Determines where this option value appears in a list of option values.
     *
     * @maps ordinal
     */
    public function setOrdinal(?int $ordinal): void
    {
        $this->ordinal['value'] = $ordinal;
    }

    /**
     * Unsets Ordinal.
     * Determines where this option value appears in a list of option values.
     */
    public function unsetOrdinal(): void
    {
        $this->ordinal = [];
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
        if (!empty($this->itemOptionId)) {
            $json['item_option_id'] = $this->itemOptionId['value'];
        }
        if (!empty($this->name)) {
            $json['name']           = $this->name['value'];
        }
        if (!empty($this->description)) {
            $json['description']    = $this->description['value'];
        }
        if (!empty($this->color)) {
            $json['color']          = $this->color['value'];
        }
        if (!empty($this->ordinal)) {
            $json['ordinal']        = $this->ordinal['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
