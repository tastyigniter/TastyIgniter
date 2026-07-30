<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class TerminalRefundQuerySort implements \JsonSerializable
{
    /**
     * @var array
     */
    private $sortOrder = [];

    /**
     * Returns Sort Order.
     * The order in which results are listed.
     * - `ASC` - Oldest to newest.
     * - `DESC` - Newest to oldest (default).
     */
    public function getSortOrder(): ?string
    {
        if (count($this->sortOrder) == 0) {
            return null;
        }
        return $this->sortOrder['value'];
    }

    /**
     * Sets Sort Order.
     * The order in which results are listed.
     * - `ASC` - Oldest to newest.
     * - `DESC` - Newest to oldest (default).
     *
     * @maps sort_order
     */
    public function setSortOrder(?string $sortOrder): void
    {
        $this->sortOrder['value'] = $sortOrder;
    }

    /**
     * Unsets Sort Order.
     * The order in which results are listed.
     * - `ASC` - Oldest to newest.
     * - `DESC` - Newest to oldest (default).
     */
    public function unsetSortOrder(): void
    {
        $this->sortOrder = [];
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
        if (!empty($this->sortOrder)) {
            $json['sort_order'] = $this->sortOrder['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
