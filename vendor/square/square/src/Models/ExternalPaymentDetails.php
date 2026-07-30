<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Stores details about an external payment. Contains only non-confidential information.
 * For more information, see
 * [Take External Payments](https://developer.squareup.com/docs/payments-api/take-payments/external-
 * payments).
 */
class ExternalPaymentDetails implements \JsonSerializable
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $source;

    /**
     * @var array
     */
    private $sourceId = [];

    /**
     * @var Money|null
     */
    private $sourceFeeMoney;

    /**
     * @param string $type
     * @param string $source
     */
    public function __construct(string $type, string $source)
    {
        $this->type = $type;
        $this->source = $source;
    }

    /**
     * Returns Type.
     * The type of external payment the seller received. It can be one of the following:
     * - CHECK - Paid using a physical check.
     * - BANK_TRANSFER - Paid using external bank transfer.
     * - OTHER\_GIFT\_CARD - Paid using a non-Square gift card.
     * - CRYPTO - Paid using a crypto currency.
     * - SQUARE_CASH - Paid using Square Cash App.
     * - SOCIAL - Paid using peer-to-peer payment applications.
     * - EXTERNAL - A third-party application gathered this payment outside of Square.
     * - EMONEY - Paid using an E-money provider.
     * - CARD - A credit or debit card that Square does not support.
     * - STORED_BALANCE - Use for house accounts, store credit, and so forth.
     * - FOOD_VOUCHER - Restaurant voucher provided by employers to employees to pay for meals
     * - OTHER - A type not listed here.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * The type of external payment the seller received. It can be one of the following:
     * - CHECK - Paid using a physical check.
     * - BANK_TRANSFER - Paid using external bank transfer.
     * - OTHER\_GIFT\_CARD - Paid using a non-Square gift card.
     * - CRYPTO - Paid using a crypto currency.
     * - SQUARE_CASH - Paid using Square Cash App.
     * - SOCIAL - Paid using peer-to-peer payment applications.
     * - EXTERNAL - A third-party application gathered this payment outside of Square.
     * - EMONEY - Paid using an E-money provider.
     * - CARD - A credit or debit card that Square does not support.
     * - STORED_BALANCE - Use for house accounts, store credit, and so forth.
     * - FOOD_VOUCHER - Restaurant voucher provided by employers to employees to pay for meals
     * - OTHER - A type not listed here.
     *
     * @required
     * @maps type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Source.
     * A description of the external payment source. For example,
     * "Food Delivery Service".
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Sets Source.
     * A description of the external payment source. For example,
     * "Food Delivery Service".
     *
     * @required
     * @maps source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    /**
     * Returns Source Id.
     * An ID to associate the payment to its originating source.
     */
    public function getSourceId(): ?string
    {
        if (count($this->sourceId) == 0) {
            return null;
        }
        return $this->sourceId['value'];
    }

    /**
     * Sets Source Id.
     * An ID to associate the payment to its originating source.
     *
     * @maps source_id
     */
    public function setSourceId(?string $sourceId): void
    {
        $this->sourceId['value'] = $sourceId;
    }

    /**
     * Unsets Source Id.
     * An ID to associate the payment to its originating source.
     */
    public function unsetSourceId(): void
    {
        $this->sourceId = [];
    }

    /**
     * Returns Source Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getSourceFeeMoney(): ?Money
    {
        return $this->sourceFeeMoney;
    }

    /**
     * Sets Source Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps source_fee_money
     */
    public function setSourceFeeMoney(?Money $sourceFeeMoney): void
    {
        $this->sourceFeeMoney = $sourceFeeMoney;
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
        $json['type']                 = $this->type;
        $json['source']               = $this->source;
        if (!empty($this->sourceId)) {
            $json['source_id']        = $this->sourceId['value'];
        }
        if (isset($this->sourceFeeMoney)) {
            $json['source_fee_money'] = $this->sourceFeeMoney;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
