<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Updates a [Subscription]($m/WebhookSubscription).
 */
class UpdateWebhookSubscriptionRequest implements \JsonSerializable
{
    /**
     * @var WebhookSubscription|null
     */
    private $subscription;

    /**
     * Returns Subscription.
     * Represents the details of a webhook subscription, including notification URL,
     * event types, and signature key.
     */
    public function getSubscription(): ?WebhookSubscription
    {
        return $this->subscription;
    }

    /**
     * Sets Subscription.
     * Represents the details of a webhook subscription, including notification URL,
     * event types, and signature key.
     *
     * @maps subscription
     */
    public function setSubscription(?WebhookSubscription $subscription): void
    {
        $this->subscription = $subscription;
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
        if (isset($this->subscription)) {
            $json['subscription'] = $this->subscription;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
