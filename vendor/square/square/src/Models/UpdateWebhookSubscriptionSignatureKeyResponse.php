<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the
 * [UpdateWebhookSubscriptionSignatureKey]($e/WebhookSubscriptions/UpdateWebhookSubscriptionSignatureKe
 * y) endpoint.
 *
 * Note: If there are errors processing the request, the [Subscription]($m/WebhookSubscription) is not
 * present.
 */
class UpdateWebhookSubscriptionSignatureKeyResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var string|null
     */
    private $signatureKey;

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
     * Returns Signature Key.
     * The new Square-generated signature key used to validate the origin of the webhook event.
     */
    public function getSignatureKey(): ?string
    {
        return $this->signatureKey;
    }

    /**
     * Sets Signature Key.
     * The new Square-generated signature key used to validate the origin of the webhook event.
     *
     * @maps signature_key
     */
    public function setSignatureKey(?string $signatureKey): void
    {
        $this->signatureKey = $signatureKey;
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
        if (isset($this->signatureKey)) {
            $json['signature_key'] = $this->signatureKey;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
