<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateGiftCardResponse;
use Square\Models\GiftCard;

/**
 * Builder for model CreateGiftCardResponse
 *
 * @see CreateGiftCardResponse
 */
class CreateGiftCardResponseBuilder
{
    /**
     * @var CreateGiftCardResponse
     */
    private $instance;

    private function __construct(CreateGiftCardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create gift card response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateGiftCardResponse());
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
     * Sets gift card field.
     */
    public function giftCard(?GiftCard $value): self
    {
        $this->instance->setGiftCard($value);
        return $this;
    }

    /**
     * Initializes a new create gift card response object.
     */
    public function build(): CreateGiftCardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
