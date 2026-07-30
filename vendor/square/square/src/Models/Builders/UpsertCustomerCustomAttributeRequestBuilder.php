<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\UpsertCustomerCustomAttributeRequest;

/**
 * Builder for model UpsertCustomerCustomAttributeRequest
 *
 * @see UpsertCustomerCustomAttributeRequest
 */
class UpsertCustomerCustomAttributeRequestBuilder
{
    /**
     * @var UpsertCustomerCustomAttributeRequest
     */
    private $instance;

    private function __construct(UpsertCustomerCustomAttributeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new upsert customer custom attribute request Builder object.
     */
    public static function init(CustomAttribute $customAttribute): self
    {
        return new self(new UpsertCustomerCustomAttributeRequest($customAttribute));
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
     * Initializes a new upsert customer custom attribute request object.
     */
    public function build(): UpsertCustomerCustomAttributeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
