<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Card;
use Square\Models\RetrieveCardResponse;

/**
 * Builder for model RetrieveCardResponse
 *
 * @see RetrieveCardResponse
 */
class RetrieveCardResponseBuilder
{
    /**
     * @var RetrieveCardResponse
     */
    private $instance;

    private function __construct(RetrieveCardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve card response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveCardResponse());
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
     * Initializes a new retrieve card response object.
     */
    public function build(): RetrieveCardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
