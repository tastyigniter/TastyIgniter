<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an [AdjustLoyaltyPoints]($e/Loyalty/AdjustLoyaltyPoints) request.
 */
class AdjustLoyaltyPointsRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var LoyaltyEventAdjustPoints
     */
    private $adjustPoints;

    /**
     * @var array
     */
    private $allowNegativeBalance = [];

    /**
     * @param string $idempotencyKey
     * @param LoyaltyEventAdjustPoints $adjustPoints
     */
    public function __construct(string $idempotencyKey, LoyaltyEventAdjustPoints $adjustPoints)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->adjustPoints = $adjustPoints;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `AdjustLoyaltyPoints` request.
     * Keys can be any valid string, but must be unique for every request.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `AdjustLoyaltyPoints` request.
     * Keys can be any valid string, but must be unique for every request.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Adjust Points.
     * Provides metadata when the event `type` is `ADJUST_POINTS`.
     */
    public function getAdjustPoints(): LoyaltyEventAdjustPoints
    {
        return $this->adjustPoints;
    }

    /**
     * Sets Adjust Points.
     * Provides metadata when the event `type` is `ADJUST_POINTS`.
     *
     * @required
     * @maps adjust_points
     */
    public function setAdjustPoints(LoyaltyEventAdjustPoints $adjustPoints): void
    {
        $this->adjustPoints = $adjustPoints;
    }

    /**
     * Returns Allow Negative Balance.
     * Indicates whether to allow a negative adjustment to result in a negative balance. If `true`, a
     * negative
     * balance is allowed when subtracting points. If `false`, Square returns a `BAD_REQUEST` error when
     * subtracting
     * the specified number of points would result in a negative balance. The default value is `false`.
     */
    public function getAllowNegativeBalance(): ?bool
    {
        if (count($this->allowNegativeBalance) == 0) {
            return null;
        }
        return $this->allowNegativeBalance['value'];
    }

    /**
     * Sets Allow Negative Balance.
     * Indicates whether to allow a negative adjustment to result in a negative balance. If `true`, a
     * negative
     * balance is allowed when subtracting points. If `false`, Square returns a `BAD_REQUEST` error when
     * subtracting
     * the specified number of points would result in a negative balance. The default value is `false`.
     *
     * @maps allow_negative_balance
     */
    public function setAllowNegativeBalance(?bool $allowNegativeBalance): void
    {
        $this->allowNegativeBalance['value'] = $allowNegativeBalance;
    }

    /**
     * Unsets Allow Negative Balance.
     * Indicates whether to allow a negative adjustment to result in a negative balance. If `true`, a
     * negative
     * balance is allowed when subtracting points. If `false`, Square returns a `BAD_REQUEST` error when
     * subtracting
     * the specified number of points would result in a negative balance. The default value is `false`.
     */
    public function unsetAllowNegativeBalance(): void
    {
        $this->allowNegativeBalance = [];
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
        $json['idempotency_key']            = $this->idempotencyKey;
        $json['adjust_points']              = $this->adjustPoints;
        if (!empty($this->allowNegativeBalance)) {
            $json['allow_negative_balance'] = $this->allowNegativeBalance['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
