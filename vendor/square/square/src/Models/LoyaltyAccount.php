<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a loyalty account in a [loyalty program]($m/LoyaltyProgram). For more information, see
 * [Create and Retrieve Loyalty Accounts](https://developer.squareup.com/docs/loyalty-api/loyalty-
 * accounts).
 */
class LoyaltyAccount implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string
     */
    private $programId;

    /**
     * @var int|null
     */
    private $balance;

    /**
     * @var int|null
     */
    private $lifetimePoints;

    /**
     * @var array
     */
    private $customerId = [];

    /**
     * @var array
     */
    private $enrolledAt = [];

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var LoyaltyAccountMapping|null
     */
    private $mapping;

    /**
     * @var array
     */
    private $expiringPointDeadlines = [];

    /**
     * @param string $programId
     */
    public function __construct(string $programId)
    {
        $this->programId = $programId;
    }

    /**
     * Returns Id.
     * The Square-assigned ID of the loyalty account.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-assigned ID of the loyalty account.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Program Id.
     * The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram) to which the account belongs.
     */
    public function getProgramId(): string
    {
        return $this->programId;
    }

    /**
     * Sets Program Id.
     * The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram) to which the account belongs.
     *
     * @required
     * @maps program_id
     */
    public function setProgramId(string $programId): void
    {
        $this->programId = $programId;
    }

    /**
     * Returns Balance.
     * The available point balance in the loyalty account. If points are scheduled to expire, they are
     * listed in the `expiring_point_deadlines` field.
     *
     * Your application should be able to handle loyalty accounts that have a negative point balance
     * (`balance` is less than 0). This might occur if a seller makes a manual adjustment or as a result of
     * a refund or exchange.
     */
    public function getBalance(): ?int
    {
        return $this->balance;
    }

    /**
     * Sets Balance.
     * The available point balance in the loyalty account. If points are scheduled to expire, they are
     * listed in the `expiring_point_deadlines` field.
     *
     * Your application should be able to handle loyalty accounts that have a negative point balance
     * (`balance` is less than 0). This might occur if a seller makes a manual adjustment or as a result of
     * a refund or exchange.
     *
     * @maps balance
     */
    public function setBalance(?int $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * Returns Lifetime Points.
     * The total points accrued during the lifetime of the account.
     */
    public function getLifetimePoints(): ?int
    {
        return $this->lifetimePoints;
    }

    /**
     * Sets Lifetime Points.
     * The total points accrued during the lifetime of the account.
     *
     * @maps lifetime_points
     */
    public function setLifetimePoints(?int $lifetimePoints): void
    {
        $this->lifetimePoints = $lifetimePoints;
    }

    /**
     * Returns Customer Id.
     * The Square-assigned ID of the [customer](entity:Customer) that is associated with the account.
     */
    public function getCustomerId(): ?string
    {
        if (count($this->customerId) == 0) {
            return null;
        }
        return $this->customerId['value'];
    }

    /**
     * Sets Customer Id.
     * The Square-assigned ID of the [customer](entity:Customer) that is associated with the account.
     *
     * @maps customer_id
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId['value'] = $customerId;
    }

    /**
     * Unsets Customer Id.
     * The Square-assigned ID of the [customer](entity:Customer) that is associated with the account.
     */
    public function unsetCustomerId(): void
    {
        $this->customerId = [];
    }

    /**
     * Returns Enrolled At.
     * The timestamp when the buyer joined the loyalty program, in RFC 3339 format. This field is used to
     * display the **Enrolled On** or **Member Since** date in first-party Square products.
     *
     * If this field is not set in a `CreateLoyaltyAccount` request, Square populates it after the buyer's
     * first action on their account
     * (when `AccumulateLoyaltyPoints` or `CreateLoyaltyReward` is called). In first-party flows, Square
     * populates the field when the buyer agrees to the terms of service in Square Point of Sale.
     *
     * This field is typically specified in a `CreateLoyaltyAccount` request when creating a loyalty
     * account for a buyer who already interacted with their account.
     * For example, you would set this field when migrating accounts from an external system. The timestamp
     * in the request can represent a current or previous date and time, but it cannot be set for the
     * future.
     */
    public function getEnrolledAt(): ?string
    {
        if (count($this->enrolledAt) == 0) {
            return null;
        }
        return $this->enrolledAt['value'];
    }

    /**
     * Sets Enrolled At.
     * The timestamp when the buyer joined the loyalty program, in RFC 3339 format. This field is used to
     * display the **Enrolled On** or **Member Since** date in first-party Square products.
     *
     * If this field is not set in a `CreateLoyaltyAccount` request, Square populates it after the buyer's
     * first action on their account
     * (when `AccumulateLoyaltyPoints` or `CreateLoyaltyReward` is called). In first-party flows, Square
     * populates the field when the buyer agrees to the terms of service in Square Point of Sale.
     *
     * This field is typically specified in a `CreateLoyaltyAccount` request when creating a loyalty
     * account for a buyer who already interacted with their account.
     * For example, you would set this field when migrating accounts from an external system. The timestamp
     * in the request can represent a current or previous date and time, but it cannot be set for the
     * future.
     *
     * @maps enrolled_at
     */
    public function setEnrolledAt(?string $enrolledAt): void
    {
        $this->enrolledAt['value'] = $enrolledAt;
    }

    /**
     * Unsets Enrolled At.
     * The timestamp when the buyer joined the loyalty program, in RFC 3339 format. This field is used to
     * display the **Enrolled On** or **Member Since** date in first-party Square products.
     *
     * If this field is not set in a `CreateLoyaltyAccount` request, Square populates it after the buyer's
     * first action on their account
     * (when `AccumulateLoyaltyPoints` or `CreateLoyaltyReward` is called). In first-party flows, Square
     * populates the field when the buyer agrees to the terms of service in Square Point of Sale.
     *
     * This field is typically specified in a `CreateLoyaltyAccount` request when creating a loyalty
     * account for a buyer who already interacted with their account.
     * For example, you would set this field when migrating accounts from an external system. The timestamp
     * in the request can represent a current or previous date and time, but it cannot be set for the
     * future.
     */
    public function unsetEnrolledAt(): void
    {
        $this->enrolledAt = [];
    }

    /**
     * Returns Created At.
     * The timestamp when the loyalty account was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp when the loyalty account was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp when the loyalty account was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp when the loyalty account was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Mapping.
     * Represents the mapping that associates a loyalty account with a buyer.
     *
     * Currently, a loyalty account can only be mapped to a buyer by phone number. For more information,
     * see
     * [Loyalty Overview](https://developer.squareup.com/docs/loyalty/overview).
     */
    public function getMapping(): ?LoyaltyAccountMapping
    {
        return $this->mapping;
    }

    /**
     * Sets Mapping.
     * Represents the mapping that associates a loyalty account with a buyer.
     *
     * Currently, a loyalty account can only be mapped to a buyer by phone number. For more information,
     * see
     * [Loyalty Overview](https://developer.squareup.com/docs/loyalty/overview).
     *
     * @maps mapping
     */
    public function setMapping(?LoyaltyAccountMapping $mapping): void
    {
        $this->mapping = $mapping;
    }

    /**
     * Returns Expiring Point Deadlines.
     * The schedule for when points expire in the loyalty account balance. This field is present only if
     * the account has points that are scheduled to expire.
     *
     * The total number of points in this field equals the number of points in the `balance` field.
     *
     * @return LoyaltyAccountExpiringPointDeadline[]|null
     */
    public function getExpiringPointDeadlines(): ?array
    {
        if (count($this->expiringPointDeadlines) == 0) {
            return null;
        }
        return $this->expiringPointDeadlines['value'];
    }

    /**
     * Sets Expiring Point Deadlines.
     * The schedule for when points expire in the loyalty account balance. This field is present only if
     * the account has points that are scheduled to expire.
     *
     * The total number of points in this field equals the number of points in the `balance` field.
     *
     * @maps expiring_point_deadlines
     *
     * @param LoyaltyAccountExpiringPointDeadline[]|null $expiringPointDeadlines
     */
    public function setExpiringPointDeadlines(?array $expiringPointDeadlines): void
    {
        $this->expiringPointDeadlines['value'] = $expiringPointDeadlines;
    }

    /**
     * Unsets Expiring Point Deadlines.
     * The schedule for when points expire in the loyalty account balance. This field is present only if
     * the account has points that are scheduled to expire.
     *
     * The total number of points in this field equals the number of points in the `balance` field.
     */
    public function unsetExpiringPointDeadlines(): void
    {
        $this->expiringPointDeadlines = [];
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
            $json['id']                       = $this->id;
        }
        $json['program_id']                   = $this->programId;
        if (isset($this->balance)) {
            $json['balance']                  = $this->balance;
        }
        if (isset($this->lifetimePoints)) {
            $json['lifetime_points']          = $this->lifetimePoints;
        }
        if (!empty($this->customerId)) {
            $json['customer_id']              = $this->customerId['value'];
        }
        if (!empty($this->enrolledAt)) {
            $json['enrolled_at']              = $this->enrolledAt['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at']               = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']               = $this->updatedAt;
        }
        if (isset($this->mapping)) {
            $json['mapping']                  = $this->mapping;
        }
        if (!empty($this->expiringPointDeadlines)) {
            $json['expiring_point_deadlines'] = $this->expiringPointDeadlines['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
