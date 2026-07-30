<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ExternalPaymentDetails;
use Square\Models\Money;

/**
 * Builder for model ExternalPaymentDetails
 *
 * @see ExternalPaymentDetails
 */
class ExternalPaymentDetailsBuilder
{
    /**
     * @var ExternalPaymentDetails
     */
    private $instance;

    private function __construct(ExternalPaymentDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new external payment details Builder object.
     */
    public static function init(string $type, string $source): self
    {
        return new self(new ExternalPaymentDetails($type, $source));
    }

    /**
     * Sets source id field.
     */
    public function sourceId(?string $value): self
    {
        $this->instance->setSourceId($value);
        return $this;
    }

    /**
     * Unsets source id field.
     */
    public function unsetSourceId(): self
    {
        $this->instance->unsetSourceId();
        return $this;
    }

    /**
     * Sets source fee money field.
     */
    public function sourceFeeMoney(?Money $value): self
    {
        $this->instance->setSourceFeeMoney($value);
        return $this;
    }

    /**
     * Initializes a new external payment details object.
     */
    public function build(): ExternalPaymentDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
