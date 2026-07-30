<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Card;
use Square\Models\TenderCardDetails;

/**
 * Builder for model TenderCardDetails
 *
 * @see TenderCardDetails
 */
class TenderCardDetailsBuilder
{
    /**
     * @var TenderCardDetails
     */
    private $instance;

    private function __construct(TenderCardDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new tender card details Builder object.
     */
    public static function init(): self
    {
        return new self(new TenderCardDetails());
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
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
     * Sets entry method field.
     */
    public function entryMethod(?string $value): self
    {
        $this->instance->setEntryMethod($value);
        return $this;
    }

    /**
     * Initializes a new tender card details object.
     */
    public function build(): TenderCardDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
