<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CalculateOrderRequest implements \JsonSerializable
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var array
     */
    private $proposedRewards = [];

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Returns Order.
     * Contains all information related to a single order to process with Square,
     * including line items that specify the products to purchase. `Order` objects also
     * include information about any associated tenders, refunds, and returns.
     *
     * All Connect V2 Transactions have all been converted to Orders including all associated
     * itemization data.
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * Sets Order.
     * Contains all information related to a single order to process with Square,
     * including line items that specify the products to purchase. `Order` objects also
     * include information about any associated tenders, refunds, and returns.
     *
     * All Connect V2 Transactions have all been converted to Orders including all associated
     * itemization data.
     *
     * @required
     * @maps order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * Returns Proposed Rewards.
     * Identifies one or more loyalty reward tiers to apply during the order calculation.
     * The discounts defined by the reward tiers are added to the order only to preview the
     * effect of applying the specified rewards. The rewards do not correspond to actual
     * redemptions; that is, no `reward`s are created. Therefore, the reward `id`s are
     * random strings used only to reference the reward tier.
     *
     * @return OrderReward[]|null
     */
    public function getProposedRewards(): ?array
    {
        if (count($this->proposedRewards) == 0) {
            return null;
        }
        return $this->proposedRewards['value'];
    }

    /**
     * Sets Proposed Rewards.
     * Identifies one or more loyalty reward tiers to apply during the order calculation.
     * The discounts defined by the reward tiers are added to the order only to preview the
     * effect of applying the specified rewards. The rewards do not correspond to actual
     * redemptions; that is, no `reward`s are created. Therefore, the reward `id`s are
     * random strings used only to reference the reward tier.
     *
     * @maps proposed_rewards
     *
     * @param OrderReward[]|null $proposedRewards
     */
    public function setProposedRewards(?array $proposedRewards): void
    {
        $this->proposedRewards['value'] = $proposedRewards;
    }

    /**
     * Unsets Proposed Rewards.
     * Identifies one or more loyalty reward tiers to apply during the order calculation.
     * The discounts defined by the reward tiers are added to the order only to preview the
     * effect of applying the specified rewards. The rewards do not correspond to actual
     * redemptions; that is, no `reward`s are created. Therefore, the reward `id`s are
     * random strings used only to reference the reward tier.
     */
    public function unsetProposedRewards(): void
    {
        $this->proposedRewards = [];
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
        $json['order']                = $this->order;
        if (!empty($this->proposedRewards)) {
            $json['proposed_rewards'] = $this->proposedRewards['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
