<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCard;
use Square\Models\LinkCustomerToGiftCardResponse;

/**
 * Builder for model LinkCustomerToGiftCardResponse
 *
 * @see LinkCustomerToGiftCardResponse
 */
class LinkCustomerToGiftCardResponseBuilder
{
    /**
     * @var LinkCustomerToGiftCardResponse
     */
    private $instance;

    private function __construct(LinkCustomerToGiftCardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new link customer to gift card response Builder object.
     */
    public static function init(): self
    {
        return new self(new LinkCustomerToGiftCardResponse());
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
     * Initializes a new link customer to gift card response object.
     */
    public function build(): LinkCustomerToGiftCardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
