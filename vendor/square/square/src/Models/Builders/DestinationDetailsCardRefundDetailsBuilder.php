<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Card;
use Square\Models\DestinationDetailsCardRefundDetails;

/**
 * Builder for model DestinationDetailsCardRefundDetails
 *
 * @see DestinationDetailsCardRefundDetails
 */
class DestinationDetailsCardRefundDetailsBuilder
{
    /**
     * @var DestinationDetailsCardRefundDetails
     */
    private $instance;

    private function __construct(DestinationDetailsCardRefundDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new destination details card refund details Builder object.
     */
    public static function init(): self
    {
        return new self(new DestinationDetailsCardRefundDetails());
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
     * Unsets entry method field.
     */
    public function unsetEntryMethod(): self
    {
        $this->instance->unsetEntryMethod();
        return $this;
    }

    /**
     * Initializes a new destination details card refund details object.
     */
    public function build(): DestinationDetailsCardRefundDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
