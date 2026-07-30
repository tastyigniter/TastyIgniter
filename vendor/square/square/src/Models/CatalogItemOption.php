<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A group of variations for a `CatalogItem`.
 */
class CatalogItemOption implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $displayName = [];

    /**
     * @var array
     */
    private $description = [];

    /**
     * @var array
     */
    private $showColors = [];

    /**
     * @var array
     */
    private $values = [];

    /**
     * Returns Name.
     * The item option's display name for the seller. Must be unique across
     * all item options. This is a searchable attribute for use in applicable query filters.
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
     * The item option's display name for the seller. Must be unique across
     * all item options. This is a searchable attribute for use in applicable query filters.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The item option's display name for the seller. Must be unique across
     * all item options. This is a searchable attribute for use in applicable query filters.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Display Name.
     * The item option's display name for the customer. This is a searchable attribute for use in
     * applicable query filters.
     */
    public function getDisplayName(): ?string
    {
        if (count($this->displayName) == 0) {
            return null;
        }
        return $this->displayName['value'];
    }

    /**
     * Sets Display Name.
     * The item option's display name for the customer. This is a searchable attribute for use in
     * applicable query filters.
     *
     * @maps display_name
     */
    public function setDisplayName(?string $displayName): void
    {
        $this->displayName['value'] = $displayName;
    }

    /**
     * Unsets Display Name.
     * The item option's display name for the customer. This is a searchable attribute for use in
     * applicable query filters.
     */
    public function unsetDisplayName(): void
    {
        $this->displayName = [];
    }

    /**
     * Returns Description.
     * The item option's human-readable description. Displayed in the Square
     * Point of Sale app for the seller and in the Online Store or on receipts for
     * the buyer. This is a searchable attribute for use in applicable query filters.
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
     * The item option's human-readable description. Displayed in the Square
     * Point of Sale app for the seller and in the Online Store or on receipts for
     * the buyer. This is a searchable attribute for use in applicable query filters.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description['value'] = $description;
    }

    /**
     * Unsets Description.
     * The item option's human-readable description. Displayed in the Square
     * Point of Sale app for the seller and in the Online Store or on receipts for
     * the buyer. This is a searchable attribute for use in applicable query filters.
     */
    public function unsetDescription(): void
    {
        $this->description = [];
    }

    /**
     * Returns Show Colors.
     * If true, display colors for entries in `values` when present.
     */
    public function getShowColors(): ?bool
    {
        if (count($this->showColors) == 0) {
            return null;
        }
        return $this->showColors['value'];
    }

    /**
     * Sets Show Colors.
     * If true, display colors for entries in `values` when present.
     *
     * @maps show_colors
     */
    public function setShowColors(?bool $showColors): void
    {
        $this->showColors['value'] = $showColors;
    }

    /**
     * Unsets Show Colors.
     * If true, display colors for entries in `values` when present.
     */
    public function unsetShowColors(): void
    {
        $this->showColors = [];
    }

    /**
     * Returns Values.
     * A list of CatalogObjects containing the
     * `CatalogItemOptionValue`s for this item.
     *
     * @return CatalogObject[]|null
     */
    public function getValues(): ?array
    {
        if (count($this->values) == 0) {
            return null;
        }
        return $this->values['value'];
    }

    /**
     * Sets Values.
     * A list of CatalogObjects containing the
     * `CatalogItemOptionValue`s for this item.
     *
     * @maps values
     *
     * @param CatalogObject[]|null $values
     */
    public function setValues(?array $values): void
    {
        $this->values['value'] = $values;
    }

    /**
     * Unsets Values.
     * A list of CatalogObjects containing the
     * `CatalogItemOptionValue`s for this item.
     */
    public function unsetValues(): void
    {
        $this->values = [];
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
            $json['name']         = $this->name['value'];
        }
        if (!empty($this->displayName)) {
            $json['display_name'] = $this->displayName['value'];
        }
        if (!empty($this->description)) {
            $json['description']  = $this->description['value'];
        }
        if (!empty($this->showColors)) {
            $json['show_colors']  = $this->showColors['value'];
        }
        if (!empty($this->values)) {
            $json['values']       = $this->values['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
