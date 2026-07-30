<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateShiftRequest;
use Square\Models\Shift;

/**
 * Builder for model CreateShiftRequest
 *
 * @see CreateShiftRequest
 */
class CreateShiftRequestBuilder
{
    /**
     * @var CreateShiftRequest
     */
    private $instance;

    private function __construct(CreateShiftRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create shift request Builder object.
     */
    public static function init(Shift $shift): self
    {
        return new self(new CreateShiftRequest($shift));
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
     * Initializes a new create shift request object.
     */
    public function build(): CreateShiftRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
