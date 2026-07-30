<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents additional data for rules with the `CATEGORY` accrual type.
 */
class LoyaltyProgramAccrualRuleCategoryData implements \JsonSerializable
{
    /**
     * @var string
     */
    private $categoryId;

    /**
     * @param string $categoryId
     */
    public function __construct(string $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * Returns Category Id.
     * The ID of the `CATEGORY` [catalog object](entity:CatalogObject) that buyers can purchase to earn
     * points.
     */
    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    /**
     * Sets Category Id.
     * The ID of the `CATEGORY` [catalog object](entity:CatalogObject) that buyers can purchase to earn
     * points.
     *
     * @required
     * @maps category_id
     */
    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
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
        $json['category_id'] = $this->categoryId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
