<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents additional data for rules with the `ITEM_VARIATION` accrual type.
 */
class LoyaltyProgramAccrualRuleItemVariationData implements \JsonSerializable
{
    /**
     * @var string
     */
    private $itemVariationId;

    /**
     * @param string $itemVariationId
     */
    public function __construct(string $itemVariationId)
    {
        $this->itemVariationId = $itemVariationId;
    }

    /**
     * Returns Item Variation Id.
     * The ID of the `ITEM_VARIATION` [catalog object](entity:CatalogObject) that buyers can purchase to
     * earn
     * points.
     */
    public function getItemVariationId(): string
    {
        return $this->itemVariationId;
    }

    /**
     * Sets Item Variation Id.
     * The ID of the `ITEM_VARIATION` [catalog object](entity:CatalogObject) that buyers can purchase to
     * earn
     * points.
     *
     * @required
     * @maps item_variation_id
     */
    public function setItemVariationId(string $itemVariationId): void
    {
        $this->itemVariationId = $itemVariationId;
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
        $json['item_variation_id'] = $this->itemVariationId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
