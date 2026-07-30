<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\UpsertLocationCustomAttributeRequest;

/**
 * Builder for model UpsertLocationCustomAttributeRequest
 *
 * @see UpsertLocationCustomAttributeRequest
 */
class UpsertLocationCustomAttributeRequestBuilder
{
    /**
     * @var UpsertLocationCustomAttributeRequest
     */
    private $instance;

    private function __construct(UpsertLocationCustomAttributeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new upsert location custom attribute request Builder object.
     */
    public static function init(CustomAttribute $customAttribute): self
    {
        return new self(new UpsertLocationCustomAttributeRequest($customAttribute));
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
     * Initializes a new upsert location custom attribute request object.
     */
    public function build(): UpsertLocationCustomAttributeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
