<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Card;
use Square\Models\CreateCardResponse;

/**
 * Builder for model CreateCardResponse
 *
 * @see CreateCardResponse
 */
class CreateCardResponseBuilder
{
    /**
     * @var CreateCardResponse
     */
    private $instance;

    private function __construct(CreateCardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create card response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateCardResponse());
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
     * Initializes a new create card response object.
     */
    public function build(): CreateCardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
