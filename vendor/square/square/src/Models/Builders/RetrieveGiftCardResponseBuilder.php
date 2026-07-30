<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCard;
use Square\Models\RetrieveGiftCardResponse;

/**
 * Builder for model RetrieveGiftCardResponse
 *
 * @see RetrieveGiftCardResponse
 */
class RetrieveGiftCardResponseBuilder
{
    /**
     * @var RetrieveGiftCardResponse
     */
    private $instance;

    private function __construct(RetrieveGiftCardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve gift card response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveGiftCardResponse());
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
     * Initializes a new retrieve gift card response object.
     */
    public function build(): RetrieveGiftCardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
