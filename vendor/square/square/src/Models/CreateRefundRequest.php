<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the body parameters that can be included in
 * a request to the [CreateRefund](api-endpoint:Transactions-CreateRefund) endpoint.
 *
 * Deprecated - recommend using [RefundPayment](api-endpoint:Refunds-RefundPayment)
 */
class CreateRefundRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var string
     */
    private $tenderId;

    /**
     * @var string|null
     */
    private $reason;

    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @param string $idempotencyKey
     * @param string $tenderId
     * @param Money $amountMoney
     */
    public function __construct(string $idempotencyKey, string $tenderId, Money $amountMoney)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->tenderId = $tenderId;
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Idempotency Key.
     * A value you specify that uniquely identifies this
     * refund among refunds you've created for the tender.
     *
     * If you're unsure whether a particular refund succeeded,
     * you can reattempt it with the same idempotency key without
     * worrying about duplicating the refund.
     *
     * See [Idempotency keys](https://developer.squareup.com/docs/working-with-apis/idempotency) for more
     * information.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A value you specify that uniquely identifies this
     * refund among refunds you've created for the tender.
     *
     * If you're unsure whether a particular refund succeeded,
     * you can reattempt it with the same idempotency key without
     * worrying about duplicating the refund.
     *
     * See [Idempotency keys](https://developer.squareup.com/docs/working-with-apis/idempotency) for more
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
     * Returns Tender Id.
     * The ID of the tender to refund.
     *
     * A [`Transaction`](entity:Transaction) has one or more `tenders` (i.e., methods
     * of payment) associated with it, and you refund each tender separately with
     * the Connect API.
     */
    public function getTenderId(): string
    {
        return $this->tenderId;
    }

    /**
     * Sets Tender Id.
     * The ID of the tender to refund.
     *
     * A [`Transaction`](entity:Transaction) has one or more `tenders` (i.e., methods
     * of payment) associated with it, and you refund each tender separately with
     * the Connect API.
     *
     * @required
     * @maps tender_id
     */
    public function setTenderId(string $tenderId): void
    {
        $this->tenderId = $tenderId;
    }

    /**
     * Returns Reason.
     * A description of the reason for the refund.
     *
     * Default value: `Refund via API`
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * Sets Reason.
     * A description of the reason for the refund.
     *
     * Default value: `Refund via API`
     *
     * @maps reason
     */
    public function setReason(?string $reason): void
    {
        $this->reason = $reason;
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
    public function getAmountMoney(): Money
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
     * @required
     * @maps amount_money
     */
    public function setAmountMoney(Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
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
        $json['idempotency_key'] = $this->idempotencyKey;
        $json['tender_id']       = $this->tenderId;
        if (isset($this->reason)) {
            $json['reason']      = $this->reason;
        }
        $json['amount_money']    = $this->amountMoney;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
