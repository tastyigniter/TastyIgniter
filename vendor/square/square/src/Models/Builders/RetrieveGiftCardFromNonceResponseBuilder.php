<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCard;
use Square\Models\RetrieveGiftCardFromNonceResponse;

/**
 * Builder for model RetrieveGiftCardFromNonceResponse
 *
 * @see RetrieveGiftCardFromNonceResponse
 */
class RetrieveGiftCardFromNonceResponseBuilder
{
    /**
     * @var RetrieveGiftCardFromNonceResponse
     */
    private $instance;

    private function __construct(RetrieveGiftCardFromNonceResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve gift card from nonce response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveGiftCardFromNonceResponse());
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
     * Initializes a new retrieve gift card from nonce response object.
     */
    public function build(): RetrieveGiftCardFromNonceResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
