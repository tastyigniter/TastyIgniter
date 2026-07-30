<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes an ad hoc item and price to generate a quick pay checkout link.
 * For more information,
 * see [Quick Pay Checkout](https://developer.squareup.com/docs/checkout-api/quick-pay-checkout).
 */
class QuickPay implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Money
     */
    private $priceMoney;

    /**
     * @var string
     */
    private $locationId;

    /**
     * @param string $name
     * @param Money $priceMoney
     * @param string $locationId
     */
    public function __construct(string $name, Money $priceMoney, string $locationId)
    {
        $this->name = $name;
        $this->priceMoney = $priceMoney;
        $this->locationId = $locationId;
    }

    /**
     * Returns Name.
     * The ad hoc item name. In the resulting `Order`, this name appears as the line item name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     * The ad hoc item name. In the resulting `Order`, this name appears as the line item name.
     *
     * @required
     * @maps name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getPriceMoney(): Money
    {
        return $this->priceMoney;
    }

    /**
     * Sets Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @required
     * @maps price_money
     */
    public function setPriceMoney(Money $priceMoney): void
    {
        $this->priceMoney = $priceMoney;
    }

    /**
     * Returns Location Id.
     * The ID of the business location the checkout is associated with.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the business location the checkout is associated with.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
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
        $json['name']        = $this->name;
        $json['price_money'] = $this->priceMoney;
        $json['location_id'] = $this->locationId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
