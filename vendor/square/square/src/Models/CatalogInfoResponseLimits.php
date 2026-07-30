<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CatalogInfoResponseLimits implements \JsonSerializable
{
    /**
     * @var array
     */
    private $batchUpsertMaxObjectsPerBatch = [];

    /**
     * @var array
     */
    private $batchUpsertMaxTotalObjects = [];

    /**
     * @var array
     */
    private $batchRetrieveMaxObjectIds = [];

    /**
     * @var array
     */
    private $searchMaxPageLimit = [];

    /**
     * @var array
     */
    private $batchDeleteMaxObjectIds = [];

    /**
     * @var array
     */
    private $updateItemTaxesMaxItemIds = [];

    /**
     * @var array
     */
    private $updateItemTaxesMaxTaxesToEnable = [];

    /**
     * @var array
     */
    private $updateItemTaxesMaxTaxesToDisable = [];

    /**
     * @var array
     */
    private $updateItemModifierListsMaxItemIds = [];

    /**
     * @var array
     */
    private $updateItemModifierListsMaxModifierListsToEnable = [];

    /**
     * @var array
     */
    private $updateItemModifierListsMaxModifierListsToDisable = [];

    /**
     * Returns Batch Upsert Max Objects Per Batch.
     * The maximum number of objects that may appear within a single batch in a
     * `/v2/catalog/batch-upsert` request.
     */
    public function getBatchUpsertMaxObjectsPerBatch(): ?int
    {
        if (count($this->batchUpsertMaxObjectsPerBatch) == 0) {
            return null;
        }
        return $this->batchUpsertMaxObjectsPerBatch['value'];
    }

    /**
     * Sets Batch Upsert Max Objects Per Batch.
     * The maximum number of objects that may appear within a single batch in a
     * `/v2/catalog/batch-upsert` request.
     *
     * @maps batch_upsert_max_objects_per_batch
     */
    public function setBatchUpsertMaxObjectsPerBatch(?int $batchUpsertMaxObjectsPerBatch): void
    {
        $this->batchUpsertMaxObjectsPerBatch['value'] = $batchUpsertMaxObjectsPerBatch;
    }

    /**
     * Unsets Batch Upsert Max Objects Per Batch.
     * The maximum number of objects that may appear within a single batch in a
     * `/v2/catalog/batch-upsert` request.
     */
    public function unsetBatchUpsertMaxObjectsPerBatch(): void
    {
        $this->batchUpsertMaxObjectsPerBatch = [];
    }

    /**
     * Returns Batch Upsert Max Total Objects.
     * The maximum number of objects that may appear across all batches in a
     * `/v2/catalog/batch-upsert` request.
     */
    public function getBatchUpsertMaxTotalObjects(): ?int
    {
        if (count($this->batchUpsertMaxTotalObjects) == 0) {
            return null;
        }
        return $this->batchUpsertMaxTotalObjects['value'];
    }

    /**
     * Sets Batch Upsert Max Total Objects.
     * The maximum number of objects that may appear across all batches in a
     * `/v2/catalog/batch-upsert` request.
     *
     * @maps batch_upsert_max_total_objects
     */
    public function setBatchUpsertMaxTotalObjects(?int $batchUpsertMaxTotalObjects): void
    {
        $this->batchUpsertMaxTotalObjects['value'] = $batchUpsertMaxTotalObjects;
    }

    /**
     * Unsets Batch Upsert Max Total Objects.
     * The maximum number of objects that may appear across all batches in a
     * `/v2/catalog/batch-upsert` request.
     */
    public function unsetBatchUpsertMaxTotalObjects(): void
    {
        $this->batchUpsertMaxTotalObjects = [];
    }

    /**
     * Returns Batch Retrieve Max Object Ids.
     * The maximum number of object IDs that may appear in a `/v2/catalog/batch-retrieve`
     * request.
     */
    public function getBatchRetrieveMaxObjectIds(): ?int
    {
        if (count($this->batchRetrieveMaxObjectIds) == 0) {
            return null;
        }
        return $this->batchRetrieveMaxObjectIds['value'];
    }

    /**
     * Sets Batch Retrieve Max Object Ids.
     * The maximum number of object IDs that may appear in a `/v2/catalog/batch-retrieve`
     * request.
     *
     * @maps batch_retrieve_max_object_ids
     */
    public function setBatchRetrieveMaxObjectIds(?int $batchRetrieveMaxObjectIds): void
    {
        $this->batchRetrieveMaxObjectIds['value'] = $batchRetrieveMaxObjectIds;
    }

    /**
     * Unsets Batch Retrieve Max Object Ids.
     * The maximum number of object IDs that may appear in a `/v2/catalog/batch-retrieve`
     * request.
     */
    public function unsetBatchRetrieveMaxObjectIds(): void
    {
        $this->batchRetrieveMaxObjectIds = [];
    }

    /**
     * Returns Search Max Page Limit.
     * The maximum number of results that may be returned in a page of a
     * `/v2/catalog/search` response.
     */
    public function getSearchMaxPageLimit(): ?int
    {
        if (count($this->searchMaxPageLimit) == 0) {
            return null;
        }
        return $this->searchMaxPageLimit['value'];
    }

    /**
     * Sets Search Max Page Limit.
     * The maximum number of results that may be returned in a page of a
     * `/v2/catalog/search` response.
     *
     * @maps search_max_page_limit
     */
    public function setSearchMaxPageLimit(?int $searchMaxPageLimit): void
    {
        $this->searchMaxPageLimit['value'] = $searchMaxPageLimit;
    }

    /**
     * Unsets Search Max Page Limit.
     * The maximum number of results that may be returned in a page of a
     * `/v2/catalog/search` response.
     */
    public function unsetSearchMaxPageLimit(): void
    {
        $this->searchMaxPageLimit = [];
    }

    /**
     * Returns Batch Delete Max Object Ids.
     * The maximum number of object IDs that may be included in a single
     * `/v2/catalog/batch-delete` request.
     */
    public function getBatchDeleteMaxObjectIds(): ?int
    {
        if (count($this->batchDeleteMaxObjectIds) == 0) {
            return null;
        }
        return $this->batchDeleteMaxObjectIds['value'];
    }

    /**
     * Sets Batch Delete Max Object Ids.
     * The maximum number of object IDs that may be included in a single
     * `/v2/catalog/batch-delete` request.
     *
     * @maps batch_delete_max_object_ids
     */
    public function setBatchDeleteMaxObjectIds(?int $batchDeleteMaxObjectIds): void
    {
        $this->batchDeleteMaxObjectIds['value'] = $batchDeleteMaxObjectIds;
    }

    /**
     * Unsets Batch Delete Max Object Ids.
     * The maximum number of object IDs that may be included in a single
     * `/v2/catalog/batch-delete` request.
     */
    public function unsetBatchDeleteMaxObjectIds(): void
    {
        $this->batchDeleteMaxObjectIds = [];
    }

    /**
     * Returns Update Item Taxes Max Item Ids.
     * The maximum number of item IDs that may be included in a single
     * `/v2/catalog/update-item-taxes` request.
     */
    public function getUpdateItemTaxesMaxItemIds(): ?int
    {
        if (count($this->updateItemTaxesMaxItemIds) == 0) {
            return null;
        }
        return $this->updateItemTaxesMaxItemIds['value'];
    }

    /**
     * Sets Update Item Taxes Max Item Ids.
     * The maximum number of item IDs that may be included in a single
     * `/v2/catalog/update-item-taxes` request.
     *
     * @maps update_item_taxes_max_item_ids
     */
    public function setUpdateItemTaxesMaxItemIds(?int $updateItemTaxesMaxItemIds): void
    {
        $this->updateItemTaxesMaxItemIds['value'] = $updateItemTaxesMaxItemIds;
    }

    /**
     * Unsets Update Item Taxes Max Item Ids.
     * The maximum number of item IDs that may be included in a single
     * `/v2/catalog/update-item-taxes` request.
     */
    public function unsetUpdateItemTaxesMaxItemIds(): void
    {
        $this->updateItemTaxesMaxItemIds = [];
    }

    /**
     * Returns Update Item Taxes Max Taxes to Enable.
     * The maximum number of tax IDs to be enabled that may be included in a single
     * `/v2/catalog/update-item-taxes` request.
     */
    public function getUpdateItemTaxesMaxTaxesToEnable(): ?int
    {
        if (count($this->updateItemTaxesMaxTaxesToEnable) == 0) {
            return null;
        }
        return $this->updateItemTaxesMaxTaxesToEnable['value'];
    }

    /**
     * Sets Update Item Taxes Max Taxes to Enable.
     * The maximum number of tax IDs to be enabled that may be included in a single
     * `/v2/catalog/update-item-taxes` request.
     *
     * @maps update_item_taxes_max_taxes_to_enable
     */
    public function setUpdateItemTaxesMaxTaxesToEnable(?int $updateItemTaxesMaxTaxesToEnable): void
    {
        $this->updateItemTaxesMaxTaxesToEnable['value'] = $updateItemTaxesMaxTaxesToEnable;
    }

    /**
     * Unsets Update Item Taxes Max Taxes to Enable.
     * The maximum number of tax IDs to be enabled that may be included in a single
     * `/v2/catalog/update-item-taxes` request.
     */
    public function unsetUpdateItemTaxesMaxTaxesToEnable(): void
    {
        $this->updateItemTaxesMaxTaxesToEnable = [];
    }

    /**
     * Returns Update Item Taxes Max Taxes to Disable.
     * The maximum number of tax IDs to be disabled that may be included in a single
     * `/v2/catalog/update-item-taxes` request.
     */
    public function getUpdateItemTaxesMaxTaxesToDisable(): ?int
    {
        if (count($this->updateItemTaxesMaxTaxesToDisable) == 0) {
            return null;
        }
        return $this->updateItemTaxesMaxTaxesToDisable['value'];
    }

    /**
     * Sets Update Item Taxes Max Taxes to Disable.
     * The maximum number of tax IDs to be disabled that may be included in a single
     * `/v2/catalog/update-item-taxes` request.
     *
     * @maps update_item_taxes_max_taxes_to_disable
     */
    public function setUpdateItemTaxesMaxTaxesToDisable(?int $updateItemTaxesMaxTaxesToDisable): void
    {
        $this->updateItemTaxesMaxTaxesToDisable['value'] = $updateItemTaxesMaxTaxesToDisable;
    }

    /**
     * Unsets Update Item Taxes Max Taxes to Disable.
     * The maximum number of tax IDs to be disabled that may be included in a single
     * `/v2/catalog/update-item-taxes` request.
     */
    public function unsetUpdateItemTaxesMaxTaxesToDisable(): void
    {
        $this->updateItemTaxesMaxTaxesToDisable = [];
    }

    /**
     * Returns Update Item Modifier Lists Max Item Ids.
     * The maximum number of item IDs that may be included in a single
     * `/v2/catalog/update-item-modifier-lists` request.
     */
    public function getUpdateItemModifierListsMaxItemIds(): ?int
    {
        if (count($this->updateItemModifierListsMaxItemIds) == 0) {
            return null;
        }
        return $this->updateItemModifierListsMaxItemIds['value'];
    }

    /**
     * Sets Update Item Modifier Lists Max Item Ids.
     * The maximum number of item IDs that may be included in a single
     * `/v2/catalog/update-item-modifier-lists` request.
     *
     * @maps update_item_modifier_lists_max_item_ids
     */
    public function setUpdateItemModifierListsMaxItemIds(?int $updateItemModifierListsMaxItemIds): void
    {
        $this->updateItemModifierListsMaxItemIds['value'] = $updateItemModifierListsMaxItemIds;
    }

    /**
     * Unsets Update Item Modifier Lists Max Item Ids.
     * The maximum number of item IDs that may be included in a single
     * `/v2/catalog/update-item-modifier-lists` request.
     */
    public function unsetUpdateItemModifierListsMaxItemIds(): void
    {
        $this->updateItemModifierListsMaxItemIds = [];
    }

    /**
     * Returns Update Item Modifier Lists Max Modifier Lists to Enable.
     * The maximum number of modifier list IDs to be enabled that may be included in
     * a single `/v2/catalog/update-item-modifier-lists` request.
     */
    public function getUpdateItemModifierListsMaxModifierListsToEnable(): ?int
    {
        if (count($this->updateItemModifierListsMaxModifierListsToEnable) == 0) {
            return null;
        }
        return $this->updateItemModifierListsMaxModifierListsToEnable['value'];
    }

    /**
     * Sets Update Item Modifier Lists Max Modifier Lists to Enable.
     * The maximum number of modifier list IDs to be enabled that may be included in
     * a single `/v2/catalog/update-item-modifier-lists` request.
     *
     * @maps update_item_modifier_lists_max_modifier_lists_to_enable
     */
    public function setUpdateItemModifierListsMaxModifierListsToEnable(
        ?int $updateItemModifierListsMaxModifierListsToEnable
    ): void {
        $this->updateItemModifierListsMaxModifierListsToEnable['value'] = $updateItemModifierListsMaxModifierListsToEnable;
    }

    /**
     * Unsets Update Item Modifier Lists Max Modifier Lists to Enable.
     * The maximum number of modifier list IDs to be enabled that may be included in
     * a single `/v2/catalog/update-item-modifier-lists` request.
     */
    public function unsetUpdateItemModifierListsMaxModifierListsToEnable(): void
    {
        $this->updateItemModifierListsMaxModifierListsToEnable = [];
    }

    /**
     * Returns Update Item Modifier Lists Max Modifier Lists to Disable.
     * The maximum number of modifier list IDs to be disabled that may be included in
     * a single `/v2/catalog/update-item-modifier-lists` request.
     */
    public function getUpdateItemModifierListsMaxModifierListsToDisable(): ?int
    {
        if (count($this->updateItemModifierListsMaxModifierListsToDisable) == 0) {
            return null;
        }
        return $this->updateItemModifierListsMaxModifierListsToDisable['value'];
    }

    /**
     * Sets Update Item Modifier Lists Max Modifier Lists to Disable.
     * The maximum number of modifier list IDs to be disabled that may be included in
     * a single `/v2/catalog/update-item-modifier-lists` request.
     *
     * @maps update_item_modifier_lists_max_modifier_lists_to_disable
     */
    public function setUpdateItemModifierListsMaxModifierListsToDisable(
        ?int $updateItemModifierListsMaxModifierListsToDisable
    ): void {
        $this->updateItemModifierListsMaxModifierListsToDisable['value'] = $updateItemModifierListsMaxModifierListsToDisable;
    }

    /**
     * Unsets Update Item Modifier Lists Max Modifier Lists to Disable.
     * The maximum number of modifier list IDs to be disabled that may be included in
     * a single `/v2/catalog/update-item-modifier-lists` request.
     */
    public function unsetUpdateItemModifierListsMaxModifierListsToDisable(): void
    {
        $this->updateItemModifierListsMaxModifierListsToDisable = [];
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
        if (!empty($this->batchUpsertMaxObjectsPerBatch)) {
            $json['batch_upsert_max_objects_per_batch']                       =
                $this->batchUpsertMaxObjectsPerBatch['value'];
        }
        if (!empty($this->batchUpsertMaxTotalObjects)) {
            $json['batch_upsert_max_total_objects']                           =
                $this->batchUpsertMaxTotalObjects['value'];
        }
        if (!empty($this->batchRetrieveMaxObjectIds)) {
            $json['batch_retrieve_max_object_ids']                            =
                $this->batchRetrieveMaxObjectIds['value'];
        }
        if (!empty($this->searchMaxPageLimit)) {
            $json['search_max_page_limit']                                    = $this->searchMaxPageLimit['value'];
        }
        if (!empty($this->batchDeleteMaxObjectIds)) {
            $json['batch_delete_max_object_ids']                              = $this->batchDeleteMaxObjectIds['value'];
        }
        if (!empty($this->updateItemTaxesMaxItemIds)) {
            $json['update_item_taxes_max_item_ids']                           =
                $this->updateItemTaxesMaxItemIds['value'];
        }
        if (!empty($this->updateItemTaxesMaxTaxesToEnable)) {
            $json['update_item_taxes_max_taxes_to_enable']                    =
                $this->updateItemTaxesMaxTaxesToEnable['value'];
        }
        if (!empty($this->updateItemTaxesMaxTaxesToDisable)) {
            $json['update_item_taxes_max_taxes_to_disable']                   =
                $this->updateItemTaxesMaxTaxesToDisable['value'];
        }
        if (!empty($this->updateItemModifierListsMaxItemIds)) {
            $json['update_item_modifier_lists_max_item_ids']                  =
                $this->updateItemModifierListsMaxItemIds['value'];
        }
        if (!empty($this->updateItemModifierListsMaxModifierListsToEnable)) {
            $json['update_item_modifier_lists_max_modifier_lists_to_enable']  =
                $this->updateItemModifierListsMaxModifierListsToEnable['value'];
        }
        if (!empty($this->updateItemModifierListsMaxModifierListsToDisable)) {
            $json['update_item_modifier_lists_max_modifier_lists_to_disable'] =
                $this->updateItemModifierListsMaxModifierListsToDisable['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
