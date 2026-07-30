<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyAccountMapping;

/**
 * Builder for model LoyaltyAccountMapping
 *
 * @see LoyaltyAccountMapping
 */
class LoyaltyAccountMappingBuilder
{
    /**
     * @var LoyaltyAccountMapping
     */
    private $instance;

    private function __construct(LoyaltyAccountMapping $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty account mapping Builder object.
     */
    public static function init(): self
    {
        return new self(new LoyaltyAccountMapping());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets phone number field.
     */
    public function phoneNumber(?string $value): self
    {
        $this->instance->setPhoneNumber($value);
        return $this;
    }

    /**
     * Unsets phone number field.
     */
    public function unsetPhoneNumber(): self
    {
        $this->instance->unsetPhoneNumber();
        return $this;
    }

    /**
     * Initializes a new loyalty account mapping object.
     */
    public function build(): LoyaltyAccountMapping
    {
        return CoreHelper::clone($this->instance);
    }
}
