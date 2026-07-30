<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCard;
use Square\Models\RetrieveGiftCardFromGANResponse;

/**
 * Builder for model RetrieveGiftCardFromGANResponse
 *
 * @see RetrieveGiftCardFromGANResponse
 */
class RetrieveGiftCardFromGANResponseBuilder
{
    /**
     * @var RetrieveGiftCardFromGANResponse
     */
    private $instance;

    private function __construct(RetrieveGiftCardFromGANResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve gift card from ganresponse Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveGiftCardFromGANResponse());
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
     * Initializes a new retrieve gift card from ganresponse object.
     */
    public function build(): RetrieveGiftCardFromGANResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
