<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\Order;
use Square\Models\OrderMoneyAmounts;
use Square\Models\OrderPricingOptions;
use Square\Models\OrderRoundingAdjustment;
use Square\Models\OrderSource;

/**
 * Builder for model Order
 *
 * @see Order
 */
class OrderBuilder
{
    /**
     * @var Order
     */
    private $instance;

    private function __construct(Order $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order Builder object.
     */
    public static function init(string $locationId): self
    {
        return new self(new Order($locationId));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets reference id field.
     */
    public function referenceId(?string $value): self
    {
        $this->instance->setReferenceId($value);
        return $this;
    }

    /**
     * Unsets reference id field.
     */
    public function unsetReferenceId(): self
    {
        $this->instance->unsetReferenceId();
        return $this;
    }

    /**
     * Sets source field.
     */
    public function source(?OrderSource $value): self
    {
        $this->instance->setSource($value);
        return $this;
    }

    /**
     * Sets customer id field.
     */
    public function customerId(?string $value): self
    {
        $this->instance->setCustomerId($value);
        return $this;
    }

    /**
     * Unsets customer id field.
     */
    public function unsetCustomerId(): self
    {
        $this->instance->unsetCustomerId();
        return $this;
    }

    /**
     * Sets line items field.
     */
    public function lineItems(?array $value): self
    {
        $this->instance->setLineItems($value);
        return $this;
    }

    /**
     * Unsets line items field.
     */
    public function unsetLineItems(): self
    {
        $this->instance->unsetLineItems();
        return $this;
    }

    /**
     * Sets taxes field.
     */
    public function taxes(?array $value): self
    {
        $this->instance->setTaxes($value);
        return $this;
    }

    /**
     * Unsets taxes field.
     */
    public function unsetTaxes(): self
    {
        $this->instance->unsetTaxes();
        return $this;
    }

    /**
     * Sets discounts field.
     */
    public function discounts(?array $value): self
    {
        $this->instance->setDiscounts($value);
        return $this;
    }

    /**
     * Unsets discounts field.
     */
    public function unsetDiscounts(): self
    {
        $this->instance->unsetDiscounts();
        return $this;
    }

    /**
     * Sets service charges field.
     */
    public function serviceCharges(?array $value): self
    {
        $this->instance->setServiceCharges($value);
        return $this;
    }

    /**
     * Unsets service charges field.
     */
    public function unsetServiceCharges(): self
    {
        $this->instance->unsetServiceCharges();
        return $this;
    }

    /**
     * Sets fulfillments field.
     */
    public function fulfillments(?array $value): self
    {
        $this->instance->setFulfillments($value);
        return $this;
    }

    /**
     * Unsets fulfillments field.
     */
    public function unsetFulfillments(): self
    {
        $this->instance->unsetFulfillments();
        return $this;
    }

    /**
     * Sets returns field.
     */
    public function returns(?array $value): self
    {
        $this->instance->setReturns($value);
        return $this;
    }

    /**
     * Sets return amounts field.
     */
    public function returnAmounts(?OrderMoneyAmounts $value): self
    {
        $this->instance->setReturnAmounts($value);
        return $this;
    }

    /**
     * Sets net amounts field.
     */
    public function netAmounts(?OrderMoneyAmounts $value): self
    {
        $this->instance->setNetAmounts($value);
        return $this;
    }

    /**
     * Sets rounding adjustment field.
     */
    public function roundingAdjustment(?OrderRoundingAdjustment $value): self
    {
        $this->instance->setRoundingAdjustment($value);
        return $this;
    }

    /**
     * Sets tenders field.
     */
    public function tenders(?array $value): self
    {
        $this->instance->setTenders($value);
        return $this;
    }

    /**
     * Sets refunds field.
     */
    public function refunds(?array $value): self
    {
        $this->instance->setRefunds($value);
        return $this;
    }

    /**
     * Sets metadata field.
     */
    public function metadata(?array $value): self
    {
        $this->instance->setMetadata($value);
        return $this;
    }

    /**
     * Unsets metadata field.
     */
    public function unsetMetadata(): self
    {
        $this->instance->unsetMetadata();
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets closed at field.
     */
    public function closedAt(?string $value): self
    {
        $this->instance->setClosedAt($value);
        return $this;
    }

    /**
     * Sets state field.
     */
    public function state(?string $value): self
    {
        $this->instance->setState($value);
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets total money field.
     */
    public function totalMoney(?Money $value): self
    {
        $this->instance->setTotalMoney($value);
        return $this;
    }

    /**
     * Sets total tax money field.
     */
    public function totalTaxMoney(?Money $value): self
    {
        $this->instance->setTotalTaxMoney($value);
        return $this;
    }

    /**
     * Sets total discount money field.
     */
    public function totalDiscountMoney(?Money $value): self
    {
        $this->instance->setTotalDiscountMoney($value);
        return $this;
    }

    /**
     * Sets total tip money field.
     */
    public function totalTipMoney(?Money $value): self
    {
        $this->instance->setTotalTipMoney($value);
        return $this;
    }

    /**
     * Sets total service charge money field.
     */
    public function totalServiceChargeMoney(?Money $value): self
    {
        $this->instance->setTotalServiceChargeMoney($value);
        return $this;
    }

    /**
     * Sets ticket name field.
     */
    public function ticketName(?string $value): self
    {
        $this->instance->setTicketName($value);
        return $this;
    }

    /**
     * Unsets ticket name field.
     */
    public function unsetTicketName(): self
    {
        $this->instance->unsetTicketName();
        return $this;
    }

    /**
     * Sets pricing options field.
     */
    public function pricingOptions(?OrderPricingOptions $value): self
    {
        $this->instance->setPricingOptions($value);
        return $this;
    }

    /**
     * Sets rewards field.
     */
    public function rewards(?array $value): self
    {
        $this->instance->setRewards($value);
        return $this;
    }

    /**
     * Sets net amount due money field.
     */
    public function netAmountDueMoney(?Money $value): self
    {
        $this->instance->setNetAmountDueMoney($value);
        return $this;
    }

    /**
     * Initializes a new order object.
     */
    public function build(): Order
    {
        return CoreHelper::clone($this->instance);
    }
}
