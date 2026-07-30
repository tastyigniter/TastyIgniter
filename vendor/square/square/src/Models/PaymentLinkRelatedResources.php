<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class PaymentLinkRelatedResources implements \JsonSerializable
{
    /**
     * @var array
     */
    private $orders = [];

    /**
     * @var array
     */
    private $subscriptionPlans = [];

    /**
     * Returns Orders.
     * The order associated with the payment link.
     *
     * @return Order[]|null
     */
    public function getOrders(): ?array
    {
        if (count($this->orders) == 0) {
            return null;
        }
        return $this->orders['value'];
    }

    /**
     * Sets Orders.
     * The order associated with the payment link.
     *
     * @maps orders
     *
     * @param Order[]|null $orders
     */
    public function setOrders(?array $orders): void
    {
        $this->orders['value'] = $orders;
    }

    /**
     * Unsets Orders.
     * The order associated with the payment link.
     */
    public function unsetOrders(): void
    {
        $this->orders = [];
    }

    /**
     * Returns Subscription Plans.
     * The subscription plan associated with the payment link.
     *
     * @return CatalogObject[]|null
     */
    public function getSubscriptionPlans(): ?array
    {
        if (count($this->subscriptionPlans) == 0) {
            return null;
        }
        return $this->subscriptionPlans['value'];
    }

    /**
     * Sets Subscription Plans.
     * The subscription plan associated with the payment link.
     *
     * @maps subscription_plans
     *
     * @param CatalogObject[]|null $subscriptionPlans
     */
    public function setSubscriptionPlans(?array $subscriptionPlans): void
    {
        $this->subscriptionPlans['value'] = $subscriptionPlans;
    }

    /**
     * Unsets Subscription Plans.
     * The subscription plan associated with the payment link.
     */
    public function unsetSubscriptionPlans(): void
    {
        $this->subscriptionPlans = [];
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
        if (!empty($this->orders)) {
            $json['orders']             = $this->orders['value'];
        }
        if (!empty($this->subscriptionPlans)) {
            $json['subscription_plans'] = $this->subscriptionPlans['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
