<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a `PublishInvoice` request.
 */
class PublishInvoiceRequest implements \JsonSerializable
{
    /**
     * @var int
     */
    private $version;

    /**
     * @var array
     */
    private $idempotencyKey = [];

    /**
     * @param int $version
     */
    public function __construct(int $version)
    {
        $this->version = $version;
    }

    /**
     * Returns Version.
     * The version of the [invoice](entity:Invoice) to publish.
     * This must match the current version of the invoice; otherwise, the request is rejected.
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The version of the [invoice](entity:Invoice) to publish.
     * This must match the current version of the invoice; otherwise, the request is rejected.
     *
     * @required
     * @maps version
     */
    public function setVersion(int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies the `PublishInvoice` request. If you do not
     * provide `idempotency_key` (or provide an empty string as the value), the endpoint
     * treats each request as independent.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        if (count($this->idempotencyKey) == 0) {
            return null;
        }
        return $this->idempotencyKey['value'];
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies the `PublishInvoice` request. If you do not
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
        $this->idempotencyKey['value'] = $idempotencyKey;
    }

    /**
     * Unsets Idempotency Key.
     * A unique string that identifies the `PublishInvoice` request. If you do not
     * provide `idempotency_key` (or provide an empty string as the value), the endpoint
     * treats each request as independent.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     */
    public function unsetIdempotencyKey(): void
    {
        $this->idempotencyKey = [];
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
        $json['version']             = $this->version;
        if (!empty($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
