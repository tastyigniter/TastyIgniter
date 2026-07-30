<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class BatchChangeInventoryRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var array
     */
    private $changes = [];

    /**
     * @var array
     */
    private $ignoreUnchangedCounts = [];

    /**
     * @param string $idempotencyKey
     */
    public function __construct(string $idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Idempotency Key.
     * A client-supplied, universally unique identifier (UUID) for the
     * request.
     *
     * See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency)
     * in the
     * [API Development 101](https://developer.squareup.com/docs/buildbasics) section for more
     * information.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A client-supplied, universally unique identifier (UUID) for the
     * request.
     *
     * See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency)
     * in the
     * [API Development 101](https://developer.squareup.com/docs/buildbasics) section for more
     * information.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Changes.
     * The set of physical counts and inventory adjustments to be made.
     * Changes are applied based on the client-supplied timestamp and may be sent
     * out of order.
     *
     * @return InventoryChange[]|null
     */
    public function getChanges(): ?array
    {
        if (count($this->changes) == 0) {
            return null;
        }
        return $this->changes['value'];
    }

    /**
     * Sets Changes.
     * The set of physical counts and inventory adjustments to be made.
     * Changes are applied based on the client-supplied timestamp and may be sent
     * out of order.
     *
     * @maps changes
     *
     * @param InventoryChange[]|null $changes
     */
    public function setChanges(?array $changes): void
    {
        $this->changes['value'] = $changes;
    }

    /**
     * Unsets Changes.
     * The set of physical counts and inventory adjustments to be made.
     * Changes are applied based on the client-supplied timestamp and may be sent
     * out of order.
     */
    public function unsetChanges(): void
    {
        $this->changes = [];
    }

    /**
     * Returns Ignore Unchanged Counts.
     * Indicates whether the current physical count should be ignored if
     * the quantity is unchanged since the last physical count. Default: `true`.
     */
    public function getIgnoreUnchangedCounts(): ?bool
    {
        if (count($this->ignoreUnchangedCounts) == 0) {
            return null;
        }
        return $this->ignoreUnchangedCounts['value'];
    }

    /**
     * Sets Ignore Unchanged Counts.
     * Indicates whether the current physical count should be ignored if
     * the quantity is unchanged since the last physical count. Default: `true`.
     *
     * @maps ignore_unchanged_counts
     */
    public function setIgnoreUnchangedCounts(?bool $ignoreUnchangedCounts): void
    {
        $this->ignoreUnchangedCounts['value'] = $ignoreUnchangedCounts;
    }

    /**
     * Unsets Ignore Unchanged Counts.
     * Indicates whether the current physical count should be ignored if
     * the quantity is unchanged since the last physical count. Default: `true`.
     */
    public function unsetIgnoreUnchangedCounts(): void
    {
        $this->ignoreUnchangedCounts = [];
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
        $json['idempotency_key']             = $this->idempotencyKey;
        if (!empty($this->changes)) {
            $json['changes']                 = $this->changes['value'];
        }
        if (!empty($this->ignoreUnchangedCounts)) {
            $json['ignore_unchanged_counts'] = $this->ignoreUnchangedCounts['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
