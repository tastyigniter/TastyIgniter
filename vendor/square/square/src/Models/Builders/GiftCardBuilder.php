<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCard;
use Square\Models\Money;

/**
 * Builder for model GiftCard
 *
 * @see GiftCard
 */
class GiftCardBuilder
{
    /**
     * @var GiftCard
     */
    private $instance;

    private function __construct(GiftCard $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card Builder object.
     */
    public static function init(string $type): self
    {
        return new self(new GiftCard($type));
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
     * Sets gan source field.
     */
    public function ganSource(?string $value): self
    {
        $this->instance->setGanSource($value);
        return $this;
    }

    /**
     * Sets state field.
     */
    public function state(?string $value): self
    {
        $this->instance->setState($value);
        return $this;
    }

    /**
     * Sets balance money field.
     */
    public function balanceMoney(?Money $value): self
    {
        $this->instance->setBalanceMoney($value);
        return $this;
    }

    /**
     * Sets gan field.
     */
    public function gan(?string $value): self
    {
        $this->instance->setGan($value);
        return $this;
    }

    /**
     * Unsets gan field.
     */
    public function unsetGan(): self
    {
        $this->instance->unsetGan();
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
     * Sets customer ids field.
     */
    public function customerIds(?array $value): self
    {
        $this->instance->setCustomerIds($value);
        return $this;
    }

    /**
     * Initializes a new gift card object.
     */
    public function build(): GiftCard
    {
        return CoreHelper::clone($this->instance);
    }
}
