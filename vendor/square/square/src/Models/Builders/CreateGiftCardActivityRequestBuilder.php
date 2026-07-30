<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateGiftCardActivityRequest;
use Square\Models\GiftCardActivity;

/**
 * Builder for model CreateGiftCardActivityRequest
 *
 * @see CreateGiftCardActivityRequest
 */
class CreateGiftCardActivityRequestBuilder
{
    /**
     * @var CreateGiftCardActivityRequest
     */
    private $instance;

    private function __construct(CreateGiftCardActivityRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create gift card activity request Builder object.
     */
    public static function init(string $idempotencyKey, GiftCardActivity $giftCardActivity): self
    {
        return new self(new CreateGiftCardActivityRequest($idempotencyKey, $giftCardActivity));
    }

    /**
     * Initializes a new create gift card activity request object.
     */
    public function build(): CreateGiftCardActivityRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
