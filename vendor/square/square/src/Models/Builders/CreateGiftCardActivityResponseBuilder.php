<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateGiftCardActivityResponse;
use Square\Models\GiftCardActivity;

/**
 * Builder for model CreateGiftCardActivityResponse
 *
 * @see CreateGiftCardActivityResponse
 */
class CreateGiftCardActivityResponseBuilder
{
    /**
     * @var CreateGiftCardActivityResponse
     */
    private $instance;

    private function __construct(CreateGiftCardActivityResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create gift card activity response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateGiftCardActivityResponse());
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
     * Sets gift card activity field.
     */
    public function giftCardActivity(?GiftCardActivity $value): self
    {
        $this->instance->setGiftCardActivity($value);
        return $this;
    }

    /**
     * Initializes a new create gift card activity response object.
     */
    public function build(): CreateGiftCardActivityResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
