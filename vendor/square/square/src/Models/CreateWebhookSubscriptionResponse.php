<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the [CreateWebhookSubscription]($e/WebhookSubscriptions/CreateWebhookSubscription)
 * endpoint.
 *
 * Note: if there are errors processing the request, the [Subscription]($m/WebhookSubscription) will
 * not be
 * present.
 */
class CreateWebhookSubscriptionResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var WebhookSubscription|null
     */
    private $subscription;

    /**
     * Returns Errors.
     * Information on errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Information on errors encountered during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

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
        if (isset($this->errors)) {
            $json['errors']       = $this->errors;
        }
        if (isset($this->subscription)) {
            $json['subscription'] = $this->subscription;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
