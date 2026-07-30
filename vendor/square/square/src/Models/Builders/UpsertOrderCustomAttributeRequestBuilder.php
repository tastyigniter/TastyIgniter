<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\UpsertOrderCustomAttributeRequest;

/**
 * Builder for model UpsertOrderCustomAttributeRequest
 *
 * @see UpsertOrderCustomAttributeRequest
 */
class UpsertOrderCustomAttributeRequestBuilder
{
    /**
     * @var UpsertOrderCustomAttributeRequest
     */
    private $instance;

    private function __construct(UpsertOrderCustomAttributeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new upsert order custom attribute request Builder object.
     */
    public static function init(CustomAttribute $customAttribute): self
    {
        return new self(new UpsertOrderCustomAttributeRequest($customAttribute));
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
     * Initializes a new upsert order custom attribute request object.
     */
    public function build(): UpsertOrderCustomAttributeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
