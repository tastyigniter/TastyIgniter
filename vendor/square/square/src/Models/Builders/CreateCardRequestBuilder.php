<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Card;
use Square\Models\CreateCardRequest;

/**
 * Builder for model CreateCardRequest
 *
 * @see CreateCardRequest
 */
class CreateCardRequestBuilder
{
    /**
     * @var CreateCardRequest
     */
    private $instance;

    private function __construct(CreateCardRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create card request Builder object.
     */
    public static function init(string $idempotencyKey, string $sourceId, Card $card): self
    {
        return new self(new CreateCardRequest($idempotencyKey, $sourceId, $card));
    }

    /**
     * Sets verification token field.
     */
    public function verificationToken(?string $value): self
    {
        $this->instance->setVerificationToken($value);
        return $this;
    }

    /**
     * Initializes a new create card request object.
     */
    public function build(): CreateCardRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
