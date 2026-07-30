<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class UpdateItemTaxesRequest implements \JsonSerializable
{
    /**
     * @var string[]
     */
    private $itemIds;

    /**
     * @var array
     */
    private $taxesToEnable = [];

    /**
     * @var array
     */
    private $taxesToDisable = [];

    /**
     * @param string[] $itemIds
     */
    public function __construct(array $itemIds)
    {
        $this->itemIds = $itemIds;
    }

    /**
     * Returns Item Ids.
     * IDs for the CatalogItems associated with the CatalogTax objects being updated.
     * No more than 1,000 IDs may be provided.
     *
     * @return string[]
     */
    public function getItemIds(): array
    {
        return $this->itemIds;
    }

    /**
     * Sets Item Ids.
     * IDs for the CatalogItems associated with the CatalogTax objects being updated.
     * No more than 1,000 IDs may be provided.
     *
     * @required
     * @maps item_ids
     *
     * @param string[] $itemIds
     */
    public function setItemIds(array $itemIds): void
    {
        $this->itemIds = $itemIds;
    }

    /**
     * Returns Taxes to Enable.
     * IDs of the CatalogTax objects to enable.
     * At least one of `taxes_to_enable` or `taxes_to_disable` must be specified.
     *
     * @return string[]|null
     */
    public function getTaxesToEnable(): ?array
    {
        if (count($this->taxesToEnable) == 0) {
            return null;
        }
        return $this->taxesToEnable['value'];
    }

    /**
     * Sets Taxes to Enable.
     * IDs of the CatalogTax objects to enable.
     * At least one of `taxes_to_enable` or `taxes_to_disable` must be specified.
     *
     * @maps taxes_to_enable
     *
     * @param string[]|null $taxesToEnable
     */
    public function setTaxesToEnable(?array $taxesToEnable): void
    {
        $this->taxesToEnable['value'] = $taxesToEnable;
    }

    /**
     * Unsets Taxes to Enable.
     * IDs of the CatalogTax objects to enable.
     * At least one of `taxes_to_enable` or `taxes_to_disable` must be specified.
     */
    public function unsetTaxesToEnable(): void
    {
        $this->taxesToEnable = [];
    }

    /**
     * Returns Taxes to Disable.
     * IDs of the CatalogTax objects to disable.
     * At least one of `taxes_to_enable` or `taxes_to_disable` must be specified.
     *
     * @return string[]|null
     */
    public function getTaxesToDisable(): ?array
    {
        if (count($this->taxesToDisable) == 0) {
            return null;
        }
        return $this->taxesToDisable['value'];
    }

    /**
     * Sets Taxes to Disable.
     * IDs of the CatalogTax objects to disable.
     * At least one of `taxes_to_enable` or `taxes_to_disable` must be specified.
     *
     * @maps taxes_to_disable
     *
     * @param string[]|null $taxesToDisable
     */
    public function setTaxesToDisable(?array $taxesToDisable): void
    {
        $this->taxesToDisable['value'] = $taxesToDisable;
    }

    /**
     * Unsets Taxes to Disable.
     * IDs of the CatalogTax objects to disable.
     * At least one of `taxes_to_enable` or `taxes_to_disable` must be specified.
     */
    public function unsetTaxesToDisable(): void
    {
        $this->taxesToDisable = [];
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
        $json['item_ids']             = $this->itemIds;
        if (!empty($this->taxesToEnable)) {
            $json['taxes_to_enable']  = $this->taxesToEnable['value'];
        }
        if (!empty($this->taxesToDisable)) {
            $json['taxes_to_disable'] = $this->taxesToDisable['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
