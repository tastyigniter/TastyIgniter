<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateGiftCardRequest;
use Square\Models\GiftCard;

/**
 * Builder for model CreateGiftCardRequest
 *
 * @see CreateGiftCardRequest
 */
class CreateGiftCardRequestBuilder
{
    /**
     * @var CreateGiftCardRequest
     */
    private $instance;

    private function __construct(CreateGiftCardRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create gift card request Builder object.
     */
    public static function init(string $idempotencyKey, string $locationId, GiftCard $giftCard): self
    {
        return new self(new CreateGiftCardRequest($idempotencyKey, $locationId, $giftCard));
    }

    /**
     * Initializes a new create gift card request object.
     */
    public function build(): CreateGiftCardRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
