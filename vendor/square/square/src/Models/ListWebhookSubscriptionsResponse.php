<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the [ListWebhookSubscriptions]($e/WebhookSubscriptions/ListWebhookSubscriptions)
 * endpoint.
 *
 * Note: if there are errors processing the request, the subscriptions field will not be
 * present.
 */
class ListWebhookSubscriptionsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var WebhookSubscription[]|null
     */
    private $subscriptions;

    /**
     * @var string|null
     */
    private $cursor;

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
     * Returns Subscriptions.
     * The requested list of [Subscription](entity:WebhookSubscription)s.
     *
     * @return WebhookSubscription[]|null
     */
    public function getSubscriptions(): ?array
    {
        return $this->subscriptions;
    }

    /**
     * Sets Subscriptions.
     * The requested list of [Subscription](entity:WebhookSubscription)s.
     *
     * @maps subscriptions
     *
     * @param WebhookSubscription[]|null $subscriptions
     */
    public function setSubscriptions(?array $subscriptions): void
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to be used in a subsequent request. If empty,
     * this is the final response.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in a subsequent request. If empty,
     * this is the final response.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
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
            $json['errors']        = $this->errors;
        }
        if (isset($this->subscriptions)) {
            $json['subscriptions'] = $this->subscriptions;
        }
        if (isset($this->cursor)) {
            $json['cursor']        = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
