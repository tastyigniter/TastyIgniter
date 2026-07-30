<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the tax IDs for an invoice recipient. The country of the seller account determines
 * whether the corresponding `tax_ids` field is available for the customer. For more information,
 * see [Invoice recipient tax IDs](https://developer.squareup.com/docs/invoices-api/overview#recipient-
 * tax-ids).
 */
class InvoiceRecipientTaxIds implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $euVat;

    /**
     * Returns Eu Vat.
     * The EU VAT identification number for the invoice recipient. For example, `IE3426675K`.
     */
    public function getEuVat(): ?string
    {
        return $this->euVat;
    }

    /**
     * Sets Eu Vat.
     * The EU VAT identification number for the invoice recipient. For example, `IE3426675K`.
     *
     * @maps eu_vat
     */
    public function setEuVat(?string $euVat): void
    {
        $this->euVat = $euVat;
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
        if (isset($this->euVat)) {
            $json['eu_vat'] = $this->euVat;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
