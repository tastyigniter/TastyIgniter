<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Card;
use Square\Models\DisableCardResponse;

/**
 * Builder for model DisableCardResponse
 *
 * @see DisableCardResponse
 */
class DisableCardResponseBuilder
{
    /**
     * @var DisableCardResponse
     */
    private $instance;

    private function __construct(DisableCardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new disable card response Builder object.
     */
    public static function init(): self
    {
        return new self(new DisableCardResponse());
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
     * Sets card field.
     */
    public function card(?Card $value): self
    {
        $this->instance->setCard($value);
        return $this;
    }

    /**
     * Initializes a new disable card response object.
     */
    public function build(): DisableCardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
