<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Creates a [Subscription]($m/WebhookSubscription).
 */
class CreateWebhookSubscriptionRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @var WebhookSubscription
     */
    private $subscription;

    /**
     * @param WebhookSubscription $subscription
     */
    public function __construct(WebhookSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies the [CreateWebhookSubscription](api-endpoint:WebhookSubscriptions-
     * CreateWebhookSubscription) request.
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies the [CreateWebhookSubscription](api-endpoint:WebhookSubscriptions-
     * CreateWebhookSubscription) request.
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Subscription.
     * Represents the details of a webhook subscription, including notification URL,
     * event types, and signature key.
     */
    public function getSubscription(): WebhookSubscription
    {
        return $this->subscription;
    }

    /**
     * Sets Subscription.
     * Represents the details of a webhook subscription, including notification URL,
     * event types, and signature key.
     *
     * @required
     * @maps subscription
     */
    public function setSubscription(WebhookSubscription $subscription): void
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
        if (isset($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey;
        }
        $json['subscription']        = $this->subscription;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
