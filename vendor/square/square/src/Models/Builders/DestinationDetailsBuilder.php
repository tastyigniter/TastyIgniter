<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DestinationDetails;
use Square\Models\DestinationDetailsCardRefundDetails;

/**
 * Builder for model DestinationDetails
 *
 * @see DestinationDetails
 */
class DestinationDetailsBuilder
{
    /**
     * @var DestinationDetails
     */
    private $instance;

    private function __construct(DestinationDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new destination details Builder object.
     */
    public static function init(): self
    {
        return new self(new DestinationDetails());
    }

    /**
     * Sets card details field.
     */
    public function cardDetails(?DestinationDetailsCardRefundDetails $value): self
    {
        $this->instance->setCardDetails($value);
        return $this;
    }

    /**
     * Initializes a new destination details object.
     */
    public function build(): DestinationDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
