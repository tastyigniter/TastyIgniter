<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * V1Settlement
 */
class V1Settlement implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var V1Money|null
     */
    private $totalMoney;

    /**
     * @var array
     */
    private $initiatedAt = [];

    /**
     * @var array
     */
    private $bankAccountId = [];

    /**
     * @var array
     */
    private $entries = [];

    /**
     * Returns Id.
     * The settlement's unique identifier.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The settlement's unique identifier.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Status.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Total Money.
     */
    public function getTotalMoney(): ?V1Money
    {
        return $this->totalMoney;
    }

    /**
     * Sets Total Money.
     *
     * @maps total_money
     */
    public function setTotalMoney(?V1Money $totalMoney): void
    {
        $this->totalMoney = $totalMoney;
    }

    /**
     * Returns Initiated At.
     * The time when the settlement was submitted for deposit or withdrawal, in ISO 8601 format.
     */
    public function getInitiatedAt(): ?string
    {
        if (count($this->initiatedAt) == 0) {
            return null;
        }
        return $this->initiatedAt['value'];
    }

    /**
     * Sets Initiated At.
     * The time when the settlement was submitted for deposit or withdrawal, in ISO 8601 format.
     *
     * @maps initiated_at
     */
    public function setInitiatedAt(?string $initiatedAt): void
    {
        $this->initiatedAt['value'] = $initiatedAt;
    }

    /**
     * Unsets Initiated At.
     * The time when the settlement was submitted for deposit or withdrawal, in ISO 8601 format.
     */
    public function unsetInitiatedAt(): void
    {
        $this->initiatedAt = [];
    }

    /**
     * Returns Bank Account Id.
     * The Square-issued unique identifier for the bank account associated with the settlement.
     */
    public function getBankAccountId(): ?string
    {
        if (count($this->bankAccountId) == 0) {
            return null;
        }
        return $this->bankAccountId['value'];
    }

    /**
     * Sets Bank Account Id.
     * The Square-issued unique identifier for the bank account associated with the settlement.
     *
     * @maps bank_account_id
     */
    public function setBankAccountId(?string $bankAccountId): void
    {
        $this->bankAccountId['value'] = $bankAccountId;
    }

    /**
     * Unsets Bank Account Id.
     * The Square-issued unique identifier for the bank account associated with the settlement.
     */
    public function unsetBankAccountId(): void
    {
        $this->bankAccountId = [];
    }

    /**
     * Returns Entries.
     * The entries included in this settlement.
     *
     * @return V1SettlementEntry[]|null
     */
    public function getEntries(): ?array
    {
        if (count($this->entries) == 0) {
            return null;
        }
        return $this->entries['value'];
    }

    /**
     * Sets Entries.
     * The entries included in this settlement.
     *
     * @maps entries
     *
     * @param V1SettlementEntry[]|null $entries
     */
    public function setEntries(?array $entries): void
    {
        $this->entries['value'] = $entries;
    }

    /**
     * Unsets Entries.
     * The entries included in this settlement.
     */
    public function unsetEntries(): void
    {
        $this->entries = [];
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
        if (isset($this->id)) {
            $json['id']              = $this->id;
        }
        if (isset($this->status)) {
            $json['status']          = $this->status;
        }
        if (isset($this->totalMoney)) {
            $json['total_money']     = $this->totalMoney;
        }
        if (!empty($this->initiatedAt)) {
            $json['initiated_at']    = $this->initiatedAt['value'];
        }
        if (!empty($this->bankAccountId)) {
            $json['bank_account_id'] = $this->bankAccountId['value'];
        }
        if (!empty($this->entries)) {
            $json['entries']         = $this->entries['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
