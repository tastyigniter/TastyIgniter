<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a `DeleteInvoice` request.
 */
class DeleteInvoiceRequest implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $version;

    /**
     * Returns Version.
     * The version of the [invoice](entity:Invoice) to delete.
     * If you do not know the version, you can call [GetInvoice](api-endpoint:Invoices-GetInvoice) or
     * [ListInvoices](api-endpoint:Invoices-ListInvoices).
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The version of the [invoice](entity:Invoice) to delete.
     * If you do not know the version, you can call [GetInvoice](api-endpoint:Invoices-GetInvoice) or
     * [ListInvoices](api-endpoint:Invoices-ListInvoices).
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
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
        if (isset($this->version)) {
            $json['version'] = $this->version;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
