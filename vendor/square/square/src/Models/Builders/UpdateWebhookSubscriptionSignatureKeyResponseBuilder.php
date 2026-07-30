<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateWebhookSubscriptionSignatureKeyResponse;

/**
 * Builder for model UpdateWebhookSubscriptionSignatureKeyResponse
 *
 * @see UpdateWebhookSubscriptionSignatureKeyResponse
 */
class UpdateWebhookSubscriptionSignatureKeyResponseBuilder
{
    /**
     * @var UpdateWebhookSubscriptionSignatureKeyResponse
     */
    private $instance;

    private function __construct(UpdateWebhookSubscriptionSignatureKeyResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update webhook subscription signature key response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateWebhookSubscriptionSignatureKeyResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Sets signature key field.
     */
    public function signatureKey(?string $value): self
    {
        $this->instance->setSignatureKey($value);
        return $this;
    }

    /**
     * Initializes a new update webhook subscription signature key response object.
     */
    public function build(): UpdateWebhookSubscriptionSignatureKeyResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
