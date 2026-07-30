<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * An accounting of the amount owed the seller and record of the actual transfer to their
 * external bank account or to the Square balance.
 */
class Payout implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string
     */
    private $locationId;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var Money|null
     */
    private $amountMoney;

    /**
     * @var Destination|null
     */
    private $destination;

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var array
     */
    private $payoutFee = [];

    /**
     * @var array
     */
    private $arrivalDate = [];

    /**
     * @param string $id
     * @param string $locationId
     */
    public function __construct(string $id, string $locationId)
    {
        $this->id = $id;
        $this->locationId = $locationId;
    }

    /**
     * Returns Id.
     * A unique ID for the payout.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * A unique ID for the payout.
     *
     * @required
     * @maps id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Status.
     * Payout status types
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * Payout status types
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Location Id.
     * The ID of the location associated with the payout.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the location associated with the payout.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Created At.
     * The timestamp of when the payout was created and submitted for deposit to the seller's banking
     * destination, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp of when the payout was created and submitted for deposit to the seller's banking
     * destination, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp of when the payout was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp of when the payout was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAmountMoney(): ?Money
    {
        return $this->amountMoney;
    }

    /**
     * Sets Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps amount_money
     */
    public function setAmountMoney(?Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Destination.
     * Information about the destination against which the payout was made.
     */
    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    /**
     * Sets Destination.
     * Information about the destination against which the payout was made.
     *
     * @maps destination
     */
    public function setDestination(?Destination $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * Returns Version.
     * The version number, which is incremented each time an update is made to this payout record.
     * The version number helps developers receive event notifications or feeds out of order.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The version number, which is incremented each time an update is made to this payout record.
     * The version number helps developers receive event notifications or feeds out of order.
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Type.
     * The type of payout: “BATCH” or “SIMPLE”.
     * BATCH payouts include a list of payout entries that can be considered settled.
     * SIMPLE payouts do not have any payout entries associated with them
     * and will show up as one of the payout entries in a future BATCH payout.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * The type of payout: “BATCH” or “SIMPLE”.
     * BATCH payouts include a list of payout entries that can be considered settled.
     * SIMPLE payouts do not have any payout entries associated with them
     * and will show up as one of the payout entries in a future BATCH payout.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Payout Fee.
     * A list of transfer fees and any taxes on the fees assessed by Square for this payout.
     *
     * @return PayoutFee[]|null
     */
    public function getPayoutFee(): ?array
    {
        if (count($this->payoutFee) == 0) {
            return null;
        }
        return $this->payoutFee['value'];
    }

    /**
     * Sets Payout Fee.
     * A list of transfer fees and any taxes on the fees assessed by Square for this payout.
     *
     * @maps payout_fee
     *
     * @param PayoutFee[]|null $payoutFee
     */
    public function setPayoutFee(?array $payoutFee): void
    {
        $this->payoutFee['value'] = $payoutFee;
    }

    /**
     * Unsets Payout Fee.
     * A list of transfer fees and any taxes on the fees assessed by Square for this payout.
     */
    public function unsetPayoutFee(): void
    {
        $this->payoutFee = [];
    }

    /**
     * Returns Arrival Date.
     * The calendar date, in ISO 8601 format (YYYY-MM-DD), when the payout is due to arrive in the seller’s
     * banking destination.
     */
    public function getArrivalDate(): ?string
    {
        if (count($this->arrivalDate) == 0) {
            return null;
        }
        return $this->arrivalDate['value'];
    }

    /**
     * Sets Arrival Date.
     * The calendar date, in ISO 8601 format (YYYY-MM-DD), when the payout is due to arrive in the seller’s
     * banking destination.
     *
     * @maps arrival_date
     */
    public function setArrivalDate(?string $arrivalDate): void
    {
        $this->arrivalDate['value'] = $arrivalDate;
    }

    /**
     * Unsets Arrival Date.
     * The calendar date, in ISO 8601 format (YYYY-MM-DD), when the payout is due to arrive in the seller’s
     * banking destination.
     */
    public function unsetArrivalDate(): void
    {
        $this->arrivalDate = [];
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
        $json['id']               = $this->id;
        if (isset($this->status)) {
            $json['status']       = $this->status;
        }
        $json['location_id']      = $this->locationId;
        if (isset($this->createdAt)) {
            $json['created_at']   = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']   = $this->updatedAt;
        }
        if (isset($this->amountMoney)) {
            $json['amount_money'] = $this->amountMoney;
        }
        if (isset($this->destination)) {
            $json['destination']  = $this->destination;
        }
        if (isset($this->version)) {
            $json['version']      = $this->version;
        }
        if (isset($this->type)) {
            $json['type']         = $this->type;
        }
        if (!empty($this->payoutFee)) {
            $json['payout_fee']   = $this->payoutFee['value'];
        }
        if (!empty($this->arrivalDate)) {
            $json['arrival_date'] = $this->arrivalDate['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
