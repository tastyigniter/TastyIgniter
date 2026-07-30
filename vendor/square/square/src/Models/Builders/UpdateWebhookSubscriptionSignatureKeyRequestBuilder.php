<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateWebhookSubscriptionSignatureKeyRequest;

/**
 * Builder for model UpdateWebhookSubscriptionSignatureKeyRequest
 *
 * @see UpdateWebhookSubscriptionSignatureKeyRequest
 */
class UpdateWebhookSubscriptionSignatureKeyRequestBuilder
{
    /**
     * @var UpdateWebhookSubscriptionSignatureKeyRequest
     */
    private $instance;

    private function __construct(UpdateWebhookSubscriptionSignatureKeyRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update webhook subscription signature key request Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateWebhookSubscriptionSignatureKeyRequest());
    }

    /**
     * Sets idempotency key field.
     */
    public function idempotencyKey(?string $value): self
    {
        $this->instance->setIdempotencyKey($value);
        return $this;
    }

    /**
     * Unsets idempotency key field.
     */
    public function unsetIdempotencyKey(): self
    {
        $this->instance->unsetIdempotencyKey();
        return $this;
    }

    /**
     * Initializes a new update webhook subscription signature key request object.
     */
    public function build(): UpdateWebhookSubscriptionSignatureKeyRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
