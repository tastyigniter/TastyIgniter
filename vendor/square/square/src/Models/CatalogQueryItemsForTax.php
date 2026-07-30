<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The query filter to return the items containing the specified tax IDs.
 */
class CatalogQueryItemsForTax implements \JsonSerializable
{
    /**
     * @var string[]
     */
    private $taxIds;

    /**
     * @param string[] $taxIds
     */
    public function __construct(array $taxIds)
    {
        $this->taxIds = $taxIds;
    }

    /**
     * Returns Tax Ids.
     * A set of `CatalogTax` IDs to be used to find associated `CatalogItem`s.
     *
     * @return string[]
     */
    public function getTaxIds(): array
    {
        return $this->taxIds;
    }

    /**
     * Sets Tax Ids.
     * A set of `CatalogTax` IDs to be used to find associated `CatalogItem`s.
     *
     * @required
     * @maps tax_ids
     *
     * @param string[] $taxIds
     */
    public function setTaxIds(array $taxIds): void
    {
        $this->taxIds = $taxIds;
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
        $json['tax_ids'] = $this->taxIds;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
