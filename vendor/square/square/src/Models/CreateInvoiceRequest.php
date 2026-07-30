<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a `CreateInvoice` request.
 */
class CreateInvoiceRequest implements \JsonSerializable
{
    /**
     * @var Invoice
     */
    private $invoice;

    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Returns Invoice.
     * Stores information about an invoice. You use the Invoices API to create and manage
     * invoices. For more information, see [Invoices API Overview](https://developer.squareup.
     * com/docs/invoices-api/overview).
     */
    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    /**
     * Sets Invoice.
     * Stores information about an invoice. You use the Invoices API to create and manage
     * invoices. For more information, see [Invoices API Overview](https://developer.squareup.
     * com/docs/invoices-api/overview).
     *
     * @required
     * @maps invoice
     */
    public function setInvoice(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies the `CreateInvoice` request. If you do not
     * provide `idempotency_key` (or provide an empty string as the value), the endpoint
     * treats each request as independent.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies the `CreateInvoice` request. If you do not
     * provide `idempotency_key` (or provide an empty string as the value), the endpoint
     * treats each request as independent.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
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
        $json['invoice']             = $this->invoice;
        if (isset($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
