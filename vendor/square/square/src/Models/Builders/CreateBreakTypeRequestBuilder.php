<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BreakType;
use Square\Models\CreateBreakTypeRequest;

/**
 * Builder for model CreateBreakTypeRequest
 *
 * @see CreateBreakTypeRequest
 */
class CreateBreakTypeRequestBuilder
{
    /**
     * @var CreateBreakTypeRequest
     */
    private $instance;

    private function __construct(CreateBreakTypeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create break type request Builder object.
     */
    public static function init(BreakType $breakType): self
    {
        return new self(new CreateBreakTypeRequest($breakType));
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
     * Initializes a new create break type request object.
     */
    public function build(): CreateBreakTypeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
