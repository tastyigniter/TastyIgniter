<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Updates a [Subscription]($m/WebhookSubscription) by replacing the existing signature key with a new
 * one.
 */
class UpdateWebhookSubscriptionSignatureKeyRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $idempotencyKey = [];

    /**
     * Returns Idempotency Key.
     * A unique string that identifies the [UpdateWebhookSubscriptionSignatureKey](api-endpoint:
     * WebhookSubscriptions-UpdateWebhookSubscriptionSignatureKey) request.
     */
    public function getIdempotencyKey(): ?string
    {
        if (count($this->idempotencyKey) == 0) {
            return null;
        }
        return $this->idempotencyKey['value'];
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies the [UpdateWebhookSubscriptionSignatureKey](api-endpoint:
     * WebhookSubscriptions-UpdateWebhookSubscriptionSignatureKey) request.
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey['value'] = $idempotencyKey;
    }

    /**
     * Unsets Idempotency Key.
     * A unique string that identifies the [UpdateWebhookSubscriptionSignatureKey](api-endpoint:
     * WebhookSubscriptions-UpdateWebhookSubscriptionSignatureKey) request.
     */
    public function unsetIdempotencyKey(): void
    {
        $this->idempotencyKey = [];
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
        if (!empty($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
